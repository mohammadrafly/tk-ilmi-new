<?php

use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(TransaksiController::class)->group(function() {
    Route::post('/payment/penuh/{kode}', 'paymentOnlinePenuh');
    Route::get('/payment/penuh/{kode}/callback/success', 'callbackSuccessPaymentOnlinePenuh');

    Route::post('/payment/cicil/{id}', 'paymentOnlineCicil');
    Route::get('/payment/cicil/{id}/callback/success', 'callbackSuccessPaymentOnlineCicil');
});
