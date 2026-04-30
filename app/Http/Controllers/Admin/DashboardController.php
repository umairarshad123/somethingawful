<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Lead;
use App\Models\ServiceRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $stats = [
            'leads_total'        => Lead::count(),
            'leads_today'        => Lead::where('created_at', '>=', $today)->count(),
            'leads_new'          => Lead::where('status', 'new')->count(),
            'users_total'        => User::count(),
            'users_today'        => User::where('created_at', '>=', $today)->count(),
            'service_requests'   => ServiceRequest::count(),
            'contact_subs'       => Lead::where('source', 'contact')->count(),
            'clients_active'     => Client::whereIn('status', ['onboarding', 'active'])->count(),
        ];

        $topServices = ServiceRequest::query()
            ->selectRaw('slug, COALESCE(service_name, slug) as name, COUNT(*) as hits')
            ->groupBy('slug', 'service_name')
            ->orderByDesc('hits')
            ->limit(8)
            ->get();

        $recentLeads = Lead::latest()->limit(5)->get();

        $recentActivity = ActivityLog::with('user')->latest()->limit(12)->get();

        return view('admin.overview', compact('stats', 'topServices', 'recentLeads', 'recentActivity'));
    }
}
