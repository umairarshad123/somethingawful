<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with(['user', 'actor']);

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('event', 'like', "%{$q}%")
                  ->orWhere('subject_label', 'like', "%{$q}%")
                  ->orWhereHas('user', fn ($u) => $u->where('email', 'like', "%{$q}%"));
            });
        }
        if ($event = $request->query('event')) {
            $query->where('event', $event);
        }

        $logs   = $query->latest()->paginate(50)->withQueryString();
        $events = ActivityLog::query()->select('event')->distinct()->orderBy('event')->pluck('event');

        return view('admin.activity-logs.index', [
            'logs'    => $logs,
            'events'  => $events,
            'filters' => $request->only(['q', 'event']),
        ]);
    }
}
