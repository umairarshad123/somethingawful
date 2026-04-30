<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Lead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $leads = $query->latest()->paginate(25)->withQueryString();

        return view('admin.leads.index', [
            'leads'    => $leads,
            'filters'  => $request->only(['q', 'status', 'service', 'source', 'from', 'to']),
            'statuses' => Lead::STATUSES,
            'sources'  => Lead::SOURCES,
        ]);
    }

    public function show(Lead $lead)
    {
        $lead->load('user');
        $activity = ActivityLog::where('subject_type', 'Lead')
            ->where('subject_id', $lead->id)
            ->latest()->limit(50)->get();

        return view('admin.leads.show', [
            'lead'     => $lead,
            'activity' => $activity,
            'statuses' => Lead::STATUSES,
        ]);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'status'          => ['nullable', 'in:' . implode(',', Lead::STATUSES)],
            'assigned_label'  => 'nullable|string|max:80',
            'internal_notes'  => 'nullable|string|max:5000',
        ]);

        $previousStatus = $lead->status;

        $lead->fill(array_filter($data, fn ($v) => $v !== null));
        $lead->last_activity_at = now();
        $lead->save();

        if (isset($data['status']) && $data['status'] !== $previousStatus) {
            ActivityLog::record(
                event: 'lead.status_changed',
                // ASCII-only label: production MySQL column charset is utf8
                // (3-byte), not utf8mb4, so multibyte characters trip a 22007.
                label: "Status: {$previousStatus} -> {$data['status']} for {$lead->email}",
                subject: $lead,
                userId: $lead->user_id,
                payload: ['from' => $previousStatus, 'to' => $data['status']],
                request: $request,
            );

            // Auto-promote to client when marked won.
            if ($data['status'] === 'won') {
                Client::firstOrCreate(
                    ['email' => $lead->email],
                    [
                        'name'      => $lead->name,
                        'phone'     => $lead->phone,
                        'company'   => $lead->company,
                        'service'   => $lead->service,
                        'status'    => 'onboarding',
                        'start_date'=> now()->toDateString(),
                        'lead_id'   => $lead->id,
                        'user_id'   => $lead->user_id,
                    ]
                );
            }
        }

        return redirect()->route('admin.leads.show', $lead)->with('flash', 'Lead updated.');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = $this->buildQuery($request);
        $filename = 'digirisers-leads-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'ID', 'Created', 'Source', 'Status', 'Name', 'Email', 'Phone',
                'Service', 'Message', 'Page', 'Assigned', 'Last activity',
            ]);
            $query->latest()->chunkById(500, function ($chunk) use ($out) {
                foreach ($chunk as $r) {
                    fputcsv($out, [
                        $r->id, optional($r->created_at)->toDateTimeString(),
                        $r->source, $r->status, $r->name, $r->email, $r->phone,
                        $r->service, str_replace(["\r","\n"], ' ', (string) $r->message),
                        $r->page, $r->assigned_label,
                        optional($r->last_activity_at)->toDateTimeString(),
                    ]);
                }
            });
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function buildQuery(Request $request)
    {
        $query = Lead::query();

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('email', 'like', "%{$q}%")
                  ->orWhere('name', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%")
                  ->orWhere('message', 'like', "%{$q}%");
            });
        }

        foreach (['status', 'source', 'service'] as $key) {
            if ($v = $request->query($key)) {
                $query->where($key, $v);
            }
        }

        if ($from = $request->query('from')) {
            $query->where('created_at', '>=', $from);
        }
        if ($to = $request->query('to')) {
            $query->where('created_at', '<=', $to . ' 23:59:59');
        }

        return $query;
    }
}
