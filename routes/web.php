<?php

use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// For the purpose of easy Testing
Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

// Handle unverified Email
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->name('verification.notice');


