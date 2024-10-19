<?php

use Illuminate\Support\Facades\Route;
use Mews\Captcha\CaptchaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Pengajuan_Cuti_Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('Pages.Auth.auth-login'); 
    
});

Route::get('/cuti', function () {
    return view('Pages.Cuti.cuti'); 
    
});

Route::get('/ajukan', function () {
    return view('pages.Cuti.ajukan'); 
    
})->name('pages.Cuti.ajukan');  



Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function (){ 
        return view('pages.App.dashboard');
    })->name('dashboard');
    Route::get('/captcha-refresh', [CaptchaController::class, 'refresh']);

    Route::resource('user', UserController::class);
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::resource('pengajuan_cuti', Pengajuan_Cuti_Controller::class);
   

    Route::get('/profile', function () {
        return view('pages.profile.index'); 
        
    })->name('pages.profile.index');  
    

    Route::get('/pengajuan_cuti/download/{id}', [Pengajuan_Cuti_Controller::class, 'download'])->name('pengajuan_cuti.download');


   


});

