<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryKegiatanController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KategoriTransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramSemesterController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
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

    Route::prefix('profile')->controller(ProfileController::class)->group(function() {
        Route::match(['PUT', 'GET'], '/{email}', 'updateProfile')->name('dashboard.update.profile');
        Route::put('/{email}/update/password', 'updatePassword')->name('dashboard.update.password');
        route::put('/{id}/update/siswa', 'updateSiswa')->name('dashboard.update.siswa');
    });

    Route::get('/daftar-pengajar', [GuruController::class, 'show'])->name('dashboard.guru.show');
    Route::get('/program-semester', [ProgramSemesterController::class, 'show'])->name('dashboard.programsemester.show');
    Route::get('/gallery-kegiatan', [GalleryKegiatanController::class, 'show'])->name('dashboard.gallerykegiatan.show');
    Route::get('/siswa/{id}/view-certificate', [SiswaController::class, 'viewCertificate'])->name('dashboard.siswa.view_certificate');
    Route::match(['PUT', 'GET'], 'pendaftaran', [SiswaController::class, 'pendaftaranSiswa'])->name('dashboard.pendaftaran.index');
    route::get('/pendaftaran/{kode}/payment/', [TransaksiController::class, 'paymentPendaftaran'])->name('dashboard.pendaftaran.payment');
    route::get('/pendaftaran/payment/option', [SiswaController::class, 'paymentOptions'])->name('dashboard.pendaftaran.paymentOptions');
    route::post('/pendaftaran/payment/option/process', [SiswaController::class, 'processPaymentOptions'])->name('dashboard.pendaftaran.processPaymentOptions');

    Route::prefix('role')->controller(RoleController::class)->group(function() {
        $resource = 'roles';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.roles.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.roles.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.roles.update');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.roles.delete');
    });

    Route::prefix('permission')->controller(PermissionController::class)->group(function() {
        $resource = 'permissions';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.permission.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.permission.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.permission.update');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.permission.delete');
    });

    Route::prefix('user')->controller(UserController::class)->group(function() {
        $resource = 'users';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.user.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.user.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.user.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.user.delete');
    });

    Route::prefix('agama')->controller(AgamaController::class)->group(function() {
        $resource = 'agama';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.agama.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.agama.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.agama.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.agama.delete');
    });

    Route::prefix('tahun-ajaran')->controller(TahunAjaranController::class)->group(function() {
        $resource = 'tahunajaran';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.tahunajaran.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.tahunajaran.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.tahunajaran.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.tahunajaran.delete');
    });

    Route::prefix('guru')->controller(GuruController::class)->group(function() {
        $resource = 'guru';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.guru.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.guru.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.guru.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.guru.delete');
    });

    Route::prefix('progsem')->controller(ProgramSemesterController::class)->group(function() {
        $resource = 'programsemester';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.programsemester.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.programsemester.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.programsemester.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.programsemester.delete');
    });

    Route::prefix('galltan')->controller(GalleryKegiatanController::class)->group(function() {
        $resource = 'gallerykegiatan';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.gallerykegiatan.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.gallerykegiatan.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.gallerykegiatan.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.gallerykegiatan.delete');
    });

    Route::prefix('siswa')->controller(SiswaController::class)->group(function() {
        $resource = 'siswa';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.siswa.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.siswa.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.siswa.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.siswa.delete');
    });

    Route::prefix('kategori')->controller(KategoriTransaksiController::class)->group(function() {
        $resource = 'kategori_transaksi';

        Route::middleware(['permission:read,' . $resource])->get('/', 'index')->name('dashboard.kategori.index');
        Route::middleware(['permission:create,' . $resource])->match(['GET', 'POST'], '/create', 'store')->name('dashboard.kategori.create');
        Route::middleware(['permission:update,' . $resource])->match(['PUT', 'GET'], '/{id}/edit', 'update')->name('dashboard.kategori.edit');
        Route::middleware(['permission:delete,' . $resource])->delete('/{id}/delete', 'destroy')->name('dashboard.kategori.delete');
    });

    Route::prefix('transaksi')->controller(TransaksiController::class)->group(function() {
        Route::get('/', 'index')->name('dashboard.transaksi.index');
        Route::match(['POST', 'GET'], 'create', 'create')->name('dashboard.transaksi.create');
        Route::match(['PUT', 'GET'], '/{id}/show', 'show')->name('dashboard.transaksi.show');
        Route::get('/download', 'download')->name('dashboard.transaksi.download');
        Route::delete('/{id}/delete', 'delete')->name('dashboard.transaksi.delete');
        Route::match(['POST', 'GET'], '/check/payment', 'checkPayment')->name('dashboard.transaksi.check');
        Route::get('/check/payment/{kode}/detail', 'checkPaymentDetail')->name('dashboard.transaksi.check.detail');
        Route::patch('/check/payment/{id}/approve/penuh', 'approvePaymentPenuh')->name('dashboard.transaksi.check.penuh');
        Route::patch('/check/payment/{id}/approve/cicil', 'approvePaymentCicil')->name('dashboard.transaksi.check.cicil');
    });
});
