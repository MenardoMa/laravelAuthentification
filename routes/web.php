<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->name('admin.')->group(function () {

    // Auth
    Route::middleware(['guest'])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('/login', 'login_form')->name('login');
            Route::post('/login', 'loginHandler')->name('login_handler');
            Route::get('/forgot-password', 'forgot_form')->name('forgot');
            Route::post('/password-reset', 'passwordHandler')->name('password_reset');
            Route::get('/password-reset-token/{token}', 'passwordResetToken')->name('password_reset_token');
            Route::post('/password-reset-token/{token}', 'passwordResetHandler')->name('password_reset_handler');
        });
    });

    // Admin
    Route::middleware(['auth'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::post('/logout', 'logoutHandler')->name('logout_handler');
        });
    });

});