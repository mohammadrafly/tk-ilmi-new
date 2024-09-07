<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('home.index', [
        'title' => 'Home'
    ]);
})->name('home');

Route::controller(AuthController::class)->group(function() {
    Route::match(['POST', 'GET'], 'login', 'login')->name('login');
    Route::match(['POST', 'GET'], 'register', 'register')->name('register');
});

Route::prefix('dashboard')->middleware(['auth'])->group(function() {
    Route::get('/', function() {
        return view('dashboard.index', [
            'title' => 'Dashboard'
        ]);
    })->name('dashboard.index');

    Route::controller(AuthController::class)->group(function() {
        Route::post('logout', 'logout')->name('logout');
    });

    Route::middleware('roleMiddleware:admin')->group(function() {

    });

    Route::middleware('roleMiddleware:siswa')->group(function() {

    });
});
