<?php

use Illuminate\Support\Facades\Route;
use Madco\AuthLogin\Controllers\AuthLoginController;

Route::get('auth/redirect', [AuthLoginController::class, 'redirectToProvider'])->name('madco.redirect');
Route::get('auth/callback', [AuthLoginController::class, 'handleProviderCallback'])->name('madco.callback');