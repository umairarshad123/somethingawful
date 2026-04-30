<?php

/*
|--------------------------------------------------------------------------
| Webhook routes — loaded with EMPTY middleware
|--------------------------------------------------------------------------
| These routes intentionally bypass the web group: no sessions, no CSRF,
| no cookies, no auth, no admin redirects. The only protection is the
| signature check inside the controller. This file is registered in
| bootstrap/app.php via withRouting(then: ...).
*/

use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle'])
    ->name('webhooks.stripe');
