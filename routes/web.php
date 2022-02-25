<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
    return view('welcome');
});
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/login', [AdminController::class, 'login'])->name('login');

    Route::group(['middleware'=>'admin_auth'],function (){
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/logout', [AdminController::class, 'logout']);

        Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/manage_category', [CategoryController::class, 'manageCategory'])->name('manage_category');
            Route::post('/insert', [CategoryController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        });
        Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
            Route::get('/', [CouponController::class, 'index'])->name('index');
            Route::get('/manage_coupon', [CouponController::class, 'manageCoupon'])->name('manage_coupon');
            Route::post('/insert', [CouponController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [CouponController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('edit');
        });


    });

});
