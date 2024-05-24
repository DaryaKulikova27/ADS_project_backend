<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Route::get('/customers', function (Request $request) {
    return $request->customer();
})->middleware('auth:sanctum');