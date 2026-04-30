<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Catalog data lives in config/catalog.php and feeds:
|   - /services            (index)
|   - /services/{slug}     (category sub-page)
|   - /shop                (catalog with cart)
|   - /shop/{slug}         (product detail)
|
| Lead capture endpoints proxy form submissions to Google Sheets via
| Apps Script web-app URLs configured in .env (see config/services.php).
|
*/

Route::get('/', fn () => view('home'))->name('home');

Route::get('/services', fn () => view('services'))->name('services');

Route::get('/services/{slug}', function (string $slug) {
    $cat = config("catalog.categories.$slug");
    abort_unless($cat, 404);
    return view('services-category', ['cat' => $cat]);
})->name('services.category');

Route::get('/shop', fn () => view('shop'))->name('shop');

Route::get('/shop/{slug}', function (string $slug) {
    foreach (config('catalog.categories', []) as $cat) {
        foreach ($cat['items'] as $item) {
            if (($item['slug'] ?? null) === $slug) {
                return view('shop-detail', ['item' => $item, 'cat' => $cat]);
            }
        }
    }
    abort(404);
})->name('shop.detail');

Route::get('/pricing', fn () => view('pricing'))->name('pricing');
Route::get('/privacy', fn () => view('privacy'))->name('privacy');
Route::get('/refund',  fn () => view('refund'))->name('refund');
Route::get('/terms',   fn () => view('terms'))->name('terms');


/*
|--------------------------------------------------------------------------
| Lead Capture — Google Sheets
|--------------------------------------------------------------------------
|
| forwardLead() validates form payload and POSTs to the Apps Script
| webhook configured in .env. The user-facing JS treats a 200 as success
| (and proceeds to its WhatsApp / thank-you flow). If the webhook URL is
| missing or fails, we log + return ok:false but the JS can still proceed
| so we never block a genuine inquiry on infrastructure issues.
|
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
                'key'  => $configKey,
                'err'  => $e->getMessage(),
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

    return response()->json([
        'ok'      => true,
        'synced'  => $result['ok'] ?? false,
    ]);
})->name('lead.submit');

Route::post('/lead/popup', function (Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:120',
        'email'   => 'required|email:rfc|max:200',
        'phone'   => 'nullable|string|max:40',
        'interest'=> 'nullable|string|max:120',
    ]);

    $result = digirisers_forward_lead('popup_url', $data, $request);

    return response()->json([
        'ok'      => true,
        'synced'  => $result['ok'] ?? false,
    ]);
})->name('lead.popup');
