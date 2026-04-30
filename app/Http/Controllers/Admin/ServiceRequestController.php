<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::with('user');

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('slug', 'like', "%{$q}%")
                  ->orWhere('service_name', 'like', "%{$q}%")
                  ->orWhereHas('user', fn ($u) => $u->where('email', 'like', "%{$q}%"));
            });
        }
        foreach (['action', 'follow_up_status', 'category'] as $key) {
            if ($v = $request->query($key)) {
                $query->where($key, $v);
            }
        }
        if ($request->query('logged_in') === 'yes') {
            $query->where('was_logged_in', true);
        } elseif ($request->query('logged_in') === 'no') {
            $query->where('was_logged_in', false);
        }

        $requests = $query->latest()->paginate(40)->withQueryString();

        $aggregated = ServiceRequest::query()
            ->selectRaw('slug, COALESCE(service_name, slug) as name, COUNT(*) as hits')
            ->groupBy('slug', 'service_name')
            ->orderByDesc('hits')
            ->limit(10)->get();

        return view('admin.service-requests.index', [
            'requests'   => $requests,
            'aggregated' => $aggregated,
            'filters'    => $request->only(['q', 'action', 'follow_up_status', 'category', 'logged_in']),
        ]);
    }
}
