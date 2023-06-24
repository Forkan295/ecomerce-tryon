<?php

use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CategoryTypeController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\TaxController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Backend/Auth/Login');
});

//Route::get('/', function () {
//    return Inertia::render('Backend/Auth/Login', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified'], 'as' => 'backend.'], function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.delete');

    Route::get('/tags', [TagController::class, 'index'])->name('tag.index');
    Route::get('/tags/create', [TagController::class, 'create'])->name('tag.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tag.store');
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tag.edit');
    Route::post('/tags/{tag}', [TagController::class, 'update'])->name('tag.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tag.delete');

    Route::get('/category-types', [CategoryTypeController::class, 'index'])->name('category_type.index');
    Route::get('/category-types/create', [CategoryTypeController::class, 'create'])->name('category_type.create');
    Route::post('/category-types', [CategoryTypeController::class, 'store'])->name('category_type.store');
    Route::get('/category-types/{categoryType}/edit', [CategoryTypeController::class, 'edit'])->name('category_type.edit');
    Route::post('/category-types/{categoryType}', [CategoryTypeController::class, 'update'])->name('category_type.update');
    Route::delete('/category-types/{categoryType}', [CategoryTypeController::class, 'destroy'])->name('category_type.delete');

    Route::get('/attributes', [AttributeController::class, 'index'])->name('attribute.index');
    Route::get('/attributes/create', [AttributeController::class, 'create'])->name('attribute.create');
    Route::post('/attributes', [AttributeController::class, 'store'])->name('attribute.store');
    Route::get('/attributes/{attributeSet}/edit', [AttributeController::class, 'edit'])->name('attribute.edit');
    Route::post('/attributes/{attributeSet}', [AttributeController::class, 'update'])->name('attribute.update');
    Route::delete('/attributes/{attributeSet}', [AttributeController::class, 'destroy'])->name('attribute.delete');

    Route::get('/taxes', [TaxController::class, 'index'])->name('tax.index');
    Route::get('/taxes/create', [TaxController::class, 'create'])->name('tax.create');
    Route::post('/taxes', [TaxController::class, 'store'])->name('tax.store');
    Route::get('/taxes/{tax}/edit', [TaxController::class, 'edit'])->name('tax.edit');
    Route::post('/taxes/{tax}', [TaxController::class, 'update'])->name('tax.update');
    Route::delete('/taxes/{tax}', [TaxController::class, 'destroy'])->name('tax.delete');

//    Route::get('/users', [UserController::class, 'index'])->name('user.index');
//    Route::get('/users/getPermissions', [UserController::class, 'getPermissions'])->name('user.permissions');
//    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
//    Route::post('/users', [UserController::class, 'store'])->name('user.store');
//    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
//    Route::post('/users/{user}', [UserController::class, 'update'])->name('user.update');
//    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.delete');

//    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
//    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
//    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
//    Route::get('/product/category/children/{category}', [ProductController::class, 'getChildCategory'])->name('category.children');
//    Route::get('/product/attrs', [ProductController::class, 'getAttrs'])->name('product.attrs');
//    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
//    Route::put('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
//    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.delete');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
