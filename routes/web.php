<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Models\ActivityLog;
use App\Models\Lead;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public marketing pages
Route::get('/', fn () => view('home'))->name('home');

Route::get('/services', fn () => view('services'))->name('services');

Route::get('/services/{slug}', function (string $slug) {
    $cat = config("catalog.categories.$slug");
    abort_unless($cat, 404);
    return view('services-category', ['cat' => $cat]);
})->name('services.category');

Route::get('/contact', fn () => view('contact'))->name('contact');
Route::get('/privacy', fn () => view('privacy'))->name('privacy');
Route::get('/refund',  fn () => view('refund'))->name('refund');
Route::get('/terms',   fn () => view('terms'))->name('terms');


/*
|--------------------------------------------------------------------------
| Auth (login + signup on one page)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/auth',           [AuthController::class, 'show'])->name('auth.show');
    Route::post('/auth/login',    [AuthController::class, 'login'])->name('auth.login');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

    // Google OAuth (Socialite)
    Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');


/*
|--------------------------------------------------------------------------
| Public catalog — anyone can browse. Pricing is hidden in the views for
| guests; signed-in users see prices + cart.
|--------------------------------------------------------------------------
*/
Route::get('/shop', fn () => view('shop'))->name('shop');

Route::get('/shop/{slug}', function (string $slug, Request $request) {
    foreach (config('catalog.categories', []) as $cat) {
        foreach ($cat['items'] as $item) {
            if (($item['slug'] ?? null) === $slug) {
                // Record a service-interest signal: every detail-page view
                // becomes a row in service_requests for the admin dashboard.
                try {
                    ServiceRequest::create([
                        'slug'           => $slug,
                        'service_name'   => $item['name'] ?? null,
                        'category'       => $cat['id'] ?? null,
                        'user_id'        => auth()->id(),
                        'was_logged_in'  => auth()->check(),
                        'action'         => 'viewed',
                        'ip'             => $request->ip(),
                        'user_agent'     => substr((string) $request->userAgent(), 0, 240),
                        'referrer'       => $request->headers->get('referer'),
                    ]);
                } catch (\Throwable $e) {
                    Log::warning('service_request log failed: ' . $e->getMessage());
                }

                // Bespoke per-service page if one exists, else the
                // dynamic shop-detail fallback.
                $bespoke = "services.{$slug}";
                if (view()->exists($bespoke)) {
                    return view($bespoke, ['item' => $item, 'cat' => $cat]);
                }
                return view('shop-detail', ['item' => $item, 'cat' => $cat]);
            }
        }
    }
    abort(404);
})->name('shop.detail');

/*
|--------------------------------------------------------------------------
| Authenticated area — only the dashboard requires login.
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                 [AdminDashboardController::class, 'index'])->name('overview');

    Route::get('/leads',            [AdminLeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/export',     [AdminLeadController::class, 'export'])->name('leads.export');
    Route::get('/leads/{lead}',     [AdminLeadController::class, 'show'])->name('leads.show');
    Route::patch('/leads/{lead}',   [AdminLeadController::class, 'update'])->name('leads.update');

    Route::get('/users',            [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}',     [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}',   [AdminUserController::class, 'update'])->name('users.update');

    Route::get('/clients',          [AdminClientController::class, 'index'])->name('clients.index');
    Route::patch('/clients/{client}', [AdminClientController::class, 'update'])->name('clients.update');

    Route::get('/service-requests', [AdminServiceRequestController::class, 'index'])->name('service-requests.index');

    // Contact submissions = leads filtered to source=contact. Reuse the lead list
    // controller with a forced filter so the admin gets a focused view.
    Route::get('/contact-submissions', function (Request $request) {
        $request->merge(['source' => 'contact']);
        return app(AdminLeadController::class)->index($request);
    })->name('contact-submissions.index');

    // Pricing requests = service requests with action=clicked_pricing.
    Route::get('/pricing-requests', function (Request $request) {
        $request->merge(['action' => 'clicked_pricing']);
        return app(AdminServiceRequestController::class)->index($request);
    })->name('pricing-requests.index');

    Route::get('/activity-logs',    [AdminActivityLogController::class, 'index'])->name('activity-logs.index');

    Route::get('/settings', fn () => view('admin.settings'))->name('settings');
});

/*
|--------------------------------------------------------------------------
| Lightweight tracking endpoints — used by the public site to record
| service-detail views and "View pricing" intent without requiring an
| auth handshake.
|--------------------------------------------------------------------------
*/
Route::post('/track/service-view', function (Request $request) {
    $data = $request->validate([
        'slug'         => 'required|string|max:120',
        'service_name' => 'nullable|string|max:200',
        'category'     => 'nullable|string|max:60',
        'action'       => 'nullable|in:viewed,clicked_pricing',
    ]);

    $sr = ServiceRequest::create([
        'slug'           => $data['slug'],
        'service_name'   => $data['service_name'] ?? null,
        'category'       => $data['category'] ?? null,
        'user_id'        => auth()->id(),
        'was_logged_in'  => auth()->check(),
        'action'         => $data['action'] ?? 'viewed',
        'ip'             => $request->ip(),
        'user_agent'     => substr((string) $request->userAgent(), 0, 240),
        'referrer'       => $request->headers->get('referer'),
    ]);

    ActivityLog::record(
        event: $sr->action === 'clicked_pricing' ? 'pricing.viewed' : 'service.viewed',
        label: ($sr->service_name ?? $sr->slug),
        subject: $sr,
        userId: auth()->id(),
        request: $request,
    );

    return response()->json(['ok' => true]);
})->name('track.service-view');


/*
|--------------------------------------------------------------------------
| Lead Capture — Google Sheets
|--------------------------------------------------------------------------
*/
if (! function_exists('digirisers_forward_lead')) {
    function digirisers_forward_lead(string $configKey, array $payload, Request $request): array
    {
        $url = config("services.gsheet.$configKey");
        if (! $url) {
            Log::warning("[lead] missing config services.gsheet.$configKey");
            return ['ok' => false, 'reason' => 'webhook_not_configured'];
        }

        $payload = array_merge($payload, [
            'timestamp' => now()->toIso8601String(),
            'page'      => $request->input('page') ?: $request->headers->get('referer'),
            'ip'        => $request->ip(),
            'ua'        => substr($request->userAgent() ?? '', 0, 240),
            'secret'    => config('services.gsheet.shared_secret'),
            'source'    => $configKey,
        ]);

        try {
            $resp = Http::timeout((int) config('services.gsheet.timeout', 8))
                ->asForm()
                ->post($url, $payload);
            return ['ok' => $resp->successful(), 'status' => $resp->status()];
        } catch (\Throwable $e) {
            Log::warning('[lead] webhook post failed', [
                'key' => $configKey,
                'err' => $e->getMessage(),
            ]);
            return ['ok' => false, 'reason' => 'webhook_error'];
        }
    }
}

Route::post('/lead/submit', function (Request $request) {
    $data = $request->validate([
        'name'       => 'required|string|max:120',
        'email'      => 'required|email:rfc|max:200',
        'phone'      => 'required|string|max:40',
        'service'    => 'required|string|max:120',
        'message'    => 'nullable|string|max:2000',
        'consent_tx' => ['required', Rule::in(['yes', '1', 'true', 'on'])],
        'consent_mk' => ['required', Rule::in(['yes', '1', 'true', 'on'])],
    ]);

    // Source detection: if the form posted from /contact, log it as contact.
    $source = str_contains((string) $request->headers->get('referer'), '/contact') ? 'contact' : 'hero';

    $lead = Lead::create([
        'name'      => $data['name'],
        'email'     => $data['email'],
        'phone'     => $data['phone'],
        'service'   => $data['service'],
        'message'   => $data['message'] ?? null,
        'source'    => $source,
        'page'      => $request->input('page') ?: $request->headers->get('referer'),
        'status'    => 'new',
        'ip'        => $request->ip(),
        'user_agent'=> substr((string) $request->userAgent(), 0, 240),
        'user_id'   => auth()->id(),
        'last_activity_at' => now(),
    ]);

    ActivityLog::record(
        event: $source === 'contact' ? 'contact.submitted' : 'lead.created',
        label: "{$data['name']} ({$data['email']}) — {$data['service']}",
        subject: $lead,
        userId: auth()->id(),
        request: $request,
    );

    // Mirror to the existing Google Sheet so nothing breaks there.
    $result = digirisers_forward_lead('lead_url', $data, $request);
    return response()->json(['ok' => true, 'synced' => $result['ok'] ?? false]);
})->name('lead.submit');

Route::post('/lead/popup', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:120',
        'email'   => 'required|email:rfc|max:200',
        'phone'   => 'nullable|string|max:40',
        'interest'=> 'nullable|string|max:120',
    ]);

    $lead = Lead::create([
        'name'      => $data['name'],
        'email'     => $data['email'],
        'phone'     => $data['phone'] ?? null,
        'service'   => $data['interest'] ?? null,
        'source'    => 'popup',
        'page'      => $request->input('page') ?: $request->headers->get('referer'),
        'status'    => 'new',
        'ip'        => $request->ip(),
        'user_agent'=> substr((string) $request->userAgent(), 0, 240),
        'user_id'   => auth()->id(),
        'last_activity_at' => now(),
    ]);

    ActivityLog::record(
        event: 'popup.submitted',
        label: "{$data['name']} ({$data['email']})",
        subject: $lead,
        userId: auth()->id(),
        request: $request,
    );

    $result = digirisers_forward_lead('popup_url', $data, $request);
    return response()->json(['ok' => true, 'synced' => $result['ok'] ?? false]);
})->name('lead.popup');
