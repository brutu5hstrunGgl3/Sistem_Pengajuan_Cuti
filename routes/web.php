<?php

use Illuminate\Support\Facades\Route;
use Mews\Captcha\CaptchaController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('Pages.Auth.auth-login'); 
    
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', function (){ 
        return view('pages.App.dashboard');
    })->name('home');
    Route::get('/captcha-refresh', [CaptchaController::class, 'refresh']);

    Route::resource('user', UserController::class);

});

