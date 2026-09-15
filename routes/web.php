<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('/lupa-password', [AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::get('/karyawan/captcha/refresh', [KaryawanController::class, 'refreshCaptcha'])->name('karyawan.captcha.refresh');
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::get('/karyawan/{karyawan}/pdf', [KaryawanController::class, 'pdf'])->name('karyawan.pdf');
    Route::get('/karyawan/{karyawan}/whatsapp', [KaryawanController::class, 'whatsapp'])->name('karyawan.whatsapp');
});
