<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Lead;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->withCount('serviceRequests');

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('email', 'like', "%{$q}%")
                  ->orWhere('first_name', 'like', "%{$q}%")
                  ->orWhere('last_name', 'like', "%{$q}%")
                  ->orWhere('company', 'like', "%{$q}%");
            });
        }
        foreach (['role', 'status'] as $key) {
            if ($v = $request->query($key)) {
                $query->where($key, $v);
            }
        }

        $users = $query->latest()->paginate(25)->withQueryString();

        return view('admin.users.index', [
            'users'   => $users,
            'filters' => $request->only(['q', 'role', 'status']),
        ]);
    }

    public function show(User $user)
    {
        $user->loadCount(['leads', 'serviceRequests']);

        $serviceRequests = ServiceRequest::where('user_id', $user->id)
            ->latest()->limit(50)->get();

        $leads = Lead::where('user_id', $user->id)->orWhere('email', $user->email)
            ->latest()->limit(20)->get();

        $activity = ActivityLog::where('user_id', $user->id)
            ->latest()->limit(50)->get();

        return view('admin.users.show', compact('user', 'serviceRequests', 'leads', 'activity'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role'   => 'nullable|in:admin,customer',
            'status' => 'nullable|in:active,suspended,deleted',
        ]);

        $user->fill(array_filter($data, fn ($v) => $v !== null))->save();

        ActivityLog::record(
            event: 'admin.user_updated',
            label: "Admin updated {$user->email}",
            subject: $user,
            userId: $user->id,
            payload: $data,
            request: $request,
        );

        return back()->with('flash', 'User updated.');
    }
}
