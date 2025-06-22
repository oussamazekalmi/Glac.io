<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DefaultValueController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\FiscController;
use App\Http\Controllers\IceCubeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorklogController;
use Illuminate\Support\Facades\Route;



Route::get('/users/forget-password', [MailController::class, 'forget_password'])->name('forget.password');
Route::post('/users/recover-password', [MailController::class, 'recover_password'])->name('recover.password');
Route::get('/users/verify-password/{hash}', [MailController::class, 'verify_password'])->name('verify.password');
Route::post('/users/confirm-password', [MailController::class, 'confirm_password'])->name('confirm.password');

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate'])->name('auth');

Route::middleware('auth')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/{id}/profile', [UserController::class, 'profile'])->name('users.profile');
        Route::get('/{id}/reset-password', [UserController::class, 'resetPasswordForm'])->name('users.reset-password-form');
        Route::put('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
    });

    Route::prefix('deliveries')->group(function () {
        Route::get('/', [DeliveryController::class, 'index'])->name('deliveries.index');
        Route::get('/create', [DeliveryController::class, 'create'])->name('deliveries.create');
        Route::post('/store', [DeliveryController::class, 'store'])->name('deliveries.store');
        Route::get('/{id}/edit', [DeliveryController::class, 'edit'])->name('deliveries.edit');
        Route::put('/{id}', [DeliveryController::class, 'update'])->name('deliveries.update');
        Route::get('/statistics', [DeliveryController::class, 'statistics'])->name('deliveries.statistics');
    });

    Route::prefix('worklogs')->group(function () {
        Route::get('/', [WorklogController::class, 'index'])->name('worklogs.index');
        Route::get('/{id}/overview', [WorklogController::class, 'overview'])->name('worklogs.overview');
        Route::get('/{id}/admin', [WorklogController::class, 'show_admin'])->name('worklogs.show-admin');
        Route::get('/{id}/employee', [WorklogController::class, 'show_employee'])->name('worklogs.show-employee');
        Route::get('/create', [WorklogController::class, 'create'])->name('worklogs.create');
        Route::post('/store', [WorklogController::class, 'store'])->name('worklogs.store');
        Route::get('/{id}/edit', [WorklogController::class, 'edit'])->name('worklogs.edit');
        Route::put('/{id}', [WorklogController::class, 'update'])->name('worklogs.update');
        Route::put('/{id}/admin', [WorklogController::class, 'update_status'])->name('worklogs.update-status');
    });

    Route::prefix('ice_cubes')->group(function () {
        Route::get('/', [IceCubeController::class, 'index'])->name('icecubes.index');
        Route::get('/logs/{id}', [IceCubeController::class, 'logs'])->name('icecubes.logs');
        Route::post('/store', [IceCubeController::class, 'store'])->name('icecubes.store');
        Route::delete('/{id}', [IceCubeController::class, 'destroy'])->name('icecubes.destroy');
        Route::post('/consolidate', [IceCubeController::class, 'consolidate'])->name('icecubes.consolidate');
    });

    Route::prefix('fiscs')->group(function () {
        Route::get('/', [FiscController::class, 'index'])->name('fiscs.index');
        Route::post('/store', [FiscController::class, 'store'])->name('fiscs.store');
        Route::get('/{fisc}/edit', [FiscController::class, 'edit'])->name('fiscs.edit');
        Route::put('/{fisc}', [FiscController::class, 'update'])->name('fiscs.update');
    });

    Route::prefix('defaults')->group(function () {
        Route::get('/defaults', [DefaultValueController::class, 'index'])->name('defaults.index');
        Route::put('/defaults/update', [DefaultValueController::class, 'update'])->name('defaults.update');

    });


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/old-data', [UserController::class, 'destroy'])->name('old-data.destroy');
});