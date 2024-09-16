<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(TransaksiController::class)->group(function() {
    Route::post('/payment/penuh/{kode}', 'paymentOnlinePenuh')->name('api.payment.penuh');
    Route::get('/payment/penuh/{kode}/callback/success', 'callbackSuccessPaymentOnlinePenuh')->name('api.callback.online.penuh');

    Route::post('/payment/cicil/{id}', 'paymentOnlineCicil');
    Route::get('/payment/cicil/{id}/callback/success', 'callbackSuccessPaymentOnlineCicil');

    Route::get('/payment/pendaftaran/{kode}/callback/success', 'callbackSuccessPaymentOnlinePendaftaran')->name('api.callback.pendaftaran');
});
