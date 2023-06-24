<?php

use App\Http\Controllers\Backend\Admin\PaymentGatewayController;
use App\Http\Controllers\Backend\Admin\PermissionController;
use App\Http\Controllers\Backend\Admin\ShippingController;
use App\Http\Controllers\Backend\Admin\SettingController;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\Admin\RoleController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest:admin'], 'prefix' => 'admin-login'], function () {
    Route::get('/', [AuthController::class, 'create'])->name('admin-login');
    Route::post('/', [AuthController::class, 'store'])->name('admin-login.request');
});

Route::group(['middleware' => ['admin'], 'prefix' => 'backend', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'admin'])->name('dashboard');
    Route::post('admin-logout', [AuthController::class, 'destroy'])->name('admin-logout');

    Route::get('/users/get-permissions', [UserController::class, 'getPermissions'])->name('user.permissions');
    Route::post('/users/check-permissions', [UserController::class, 'checkPermissions'])->name('user.permission.check');
    Route::resource('users', UserController::class);
    Route::resource('admins', AdminController::class);

    Route::get('role', [RoleController::class, 'index'])->name('role.index');
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('role/{role}/update', [RoleController::class, 'update'])->name('role.update');
    Route::delete('role/{role}/delete', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('permission/{permission}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('permission/{permission}/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('permission/{permission}/delete', [PermissionController::class, 'destroy'])->name('permission.destroy');

//    Route::get('clients/{user?}', [ClientController::class, 'index'])->name('client.index');
//    Route::get('clients/{user?}/create', [ClientController::class, 'create'])->name('client.create');
//    Route::post('clients/{user?}', [ClientController::class, 'store'])->name('client.store');
//    Route::get('clients/{client}', [ClientController::class, 'destroy'])->name('client.delete');
//    Route::get('clients/get-secret/{id}', [ClientController::class, 'getSecret'])->name('client.get-secret');

    Route::group(['prefix' => 'setting'], function() {
        Route::get('store-detail', [SettingController::class, 'index'])->name('store-detail.index');
        Route::get('store-detail/create', [SettingController::class, 'create'])->name('store-detail.create');
        Route::post('store-detail', [SettingController::class, 'store'])->name('store-detail.store');
        Route::get('store-detail/{setting}', [SettingController::class, 'edit'])->name('store-detail.edit');
        Route::post('store-detail/{setting}', [SettingController::class, 'update'])->name('store-detail.update');
        Route::delete('store-detail/{setting}', [SettingController::class, 'destroy'])->name('store-detail.destroy');

        Route::resource('shipping', ShippingController::class);
        Route::resource('gateway', PaymentGatewayController::class);
    });
});
