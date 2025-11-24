<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->name('admin.')->group(function () {

    // Auth
    Route::middleware([])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('/login', 'login_form')->name('login');
            Route::post('/login', 'loginHandler')->name('login_handler');
            Route::get('/forgot-password', 'forgot_form')->name('forgot');
        });
    });

    // Admin
    Route::middleware([])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
        });
    });

});