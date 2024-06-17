<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
});
Route::resource('login', LoginController::class)->names([
    'index' => 'auth.login',
]);
Route::resource('register', RegisterController::class)->names([
    'index' => 'auth.register.index',
]);
Route::get('logout', [LogoutController::class, 'index'])->name('logout');

Route::middleware(['multi'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::resource('nilai', NilaiController::class)->names([
        'index' => 'nilai.index',
        'store' => 'nilai.store',
        'update' => 'nilai.update',
        'destroy' => 'nilai.destroy',
    ]);
});

Route::middleware(['admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::resource('user', UserController::class)->names([
        'index' => 'users.index',
        'store' => 'users.store',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
    Route::resource('karyawan', KaryawanController::class)->names([
        'index' => 'karyawan.index',
        'store' => 'karyawan.store',
        'update' => 'karyawan.update',
        'destroy' => 'karyawan.destroy',
    ]);
    Route::resource('kriteria', KriteriaController::class)->names([
        'index' => 'kriteria.index',
        'store' => 'kriteria.store',
        'update' => 'kriteria.update',
        'destroy' => 'kriteria.destroy',
    ]);
    Route::resource('bobot', BobotController::class)->names([
        'index' => 'bobot.index',
        'store' => 'bobot.store',
        'update' => 'bobot.update',
        'destroy' => 'bobot.destroy',
    ]);
});
