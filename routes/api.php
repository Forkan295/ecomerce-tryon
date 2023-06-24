<?php

use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/category', [CategoryController::class, 'getCategories']);
    Route::get('/category-type', [ProductTypeController::class, 'getProductTypes']);
    Route::get('/product', [ProductController::class, 'getProducts']);
    Route::post('/product/{product}', [ProductController::class, 'storeView']);
});

