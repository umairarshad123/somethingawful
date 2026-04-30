<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
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

Route::get('/shop/{slug}', function (string $slug) {
    foreach (config('catalog.categories', []) as $cat) {
        foreach ($cat['items'] as $item) {
            if (($item['slug'] ?? null) === $slug) {
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

    $result = digirisers_forward_lead('popup_url', $data, $request);
    return response()->json(['ok' => true, 'synced' => $result['ok'] ?? false]);
})->name('lead.popup');
