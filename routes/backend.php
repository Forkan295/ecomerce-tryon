<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\OauthController;
use App\Http\Controllers\Backend\PaymentGatewayController;
use App\Http\Controllers\Backend\CategoryTypeController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ShippingController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\TaxController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/admin', [AuthenticatedSessionController::class, 'create']);
});

Route::group(['middleware' => ['auth'], 'as' => 'backend.'], function () {
    Route::get('/authorize', [OauthController::class, 'authorization'])->name('oauth.authorize');
    Route::get('/callback', [OauthController::class, 'token'])->name('oauth.token');
    Route::get('/revoke/{token}', [OauthController::class, 'revoke'])->name('oauth.revoke');


    Route::group(['prefix' => '{tenant?}', 'middleware' => 'identifyTenant'], function () {
        Route::get('/get-tokens', [OauthController::class, 'getToken'])->name('oauth.getToken');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('tags', TagController::class);
        Route::resource('category-types', CategoryTypeController::class);

        Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::resource('categories', CategoryController::class);

        Route::resource('attributes', AttributeController::class);
        Route::resource('taxes', TaxController::class);

        Route::group(['prefix' => 'setting'], function () {
            Route::get('store-details', [SettingController::class, 'index'])->name('store-details.index');
            Route::post('store-details', [SettingController::class, 'update'])->name('store-details.update');

            Route::resource('shipping', ShippingController::class);
            Route::resource('gateway', PaymentGatewayController::class);
        });

        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/category/children/{category}', [ProductController::class, 'getChildCategory'])->name('category.children');
        Route::get('/product/attrs', [ProductController::class, 'getAttrs'])->name('product.attrs');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
        Route::post('/product/single-media/delete', [ProductController::class, 'productSingleMediaDelete'])->name('single-product-media.delete');
        Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.delete');
        Route::delete('/product/attribute/{attribute}', [ProductController::class, 'destroyAttribute'])->name('product.attribute.delete');

        Route::get('clients', [ClientController::class, 'index'])->name('client.index');
        Route::get('clients/create', [ClientController::class, 'create'])->name('client.create');
        Route::post('clients', [ClientController::class, 'store'])->name('client.store');
        Route::Delete('clients/{client}', [ClientController::class, 'destroy'])->name('client.delete');
        Route::get('clients/get-secret/{id}', [ClientController::class, 'getSecret'])->name('client.get-secret');

        Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
        Route::get('menu/create', [MenuController::class, 'create'])->name('menu.create');
        Route::post('menu/store', [MenuController::class, 'create'])->name('menu.create');
        Route::get('menu/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('menu/menu/update', [MenuController::class, 'edit'])->name('menu.update');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__ . '/auth.php';
