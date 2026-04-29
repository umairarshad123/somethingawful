<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/refund', function () {
    return view('refund');
})->name('refund');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');
