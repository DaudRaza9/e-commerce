<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HomeBannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;

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


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/login', [AdminController::class, 'login'])->name('login');

    Route::group(['middleware'=>'admin_auth'],function (){
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

        //---Category Routes---//
        Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/manage_category', [CategoryController::class, 'manageCategory'])->name('manage_category');
            Route::post('/insert', [CategoryController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('/update', [CategoryController::class, 'update'])->name('update');
            Route::get('/status/{status}/{id}', [CategoryController::class, 'status'])->name('status');
            Route::get('/select_categories', [CategoryController::class, 'selectCategories'])->name('select_categories');
        });

        //---Coupon Routes---//
        Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
            Route::get('/', [CouponController::class, 'index'])->name('index');
            Route::get('/manage_coupon', [CouponController::class, 'manageCoupon'])->name('manage_coupon');
            Route::post('/insert', [CouponController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [CouponController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('edit');
            Route::get('/status/{status}/{id}', [CouponController::class, 'status'])->name('status');
        });

        //---Size Routes---//
        Route::group(['prefix' => 'size', 'as' => 'size.'], function () {
            Route::get('/', [SizeController::class, 'index'])->name('index');
            Route::get('/manage_size', [SizeController::class, 'manageSize'])->name('manage_size');
            Route::post('/insert', [SizeController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [SizeController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [SizeController::class, 'edit'])->name('edit');
            Route::get('/status/{status}/{id}', [SizeController::class, 'status'])->name('status');
            Route::get('/select_size', [SizeController::class, 'SelectProductSize'])->name('select_size');
        });

        //---Color Routes---//
        Route::group(['prefix' => 'color', 'as' => 'color.'], function () {
            Route::get('/', [ColorController::class, 'index'])->name('index');
            Route::get('/manage_color', [ColorController::class, 'manageColor'])->name('manage_color');
            Route::post('/insert', [ColorController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [ColorController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('edit');
            Route::get('/status/{status}/{id}', [ColorController::class, 'status'])->name('status');
            Route::get('/select_color', [ColorController::class, 'selectColor'])->name('select_color');
        });

        //---Products Routes---//
        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create_product', [ProductController::class, 'createProduct'])->name('create_product');
            Route::post('/insert', [ProductController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
            Route::post('/update', [ProductController::class, 'update'])->name('update');
            Route::get('/status/{status}/{id}', [ProductController::class, 'status'])->name('status');
            Route::get('/imageDelete/{pId}/{pIId}', [ProductController::class, 'imageDelete'])->name('imageDelete');
            Route::get('/productAttributeImageDelete/{pId}/{pIId}', [ProductController::class, 'productAttributeDelete'])->name('productAttributeImageDelete');
        });

        //--Brand Routes--//
        Route::group(['prefix' => 'brand', 'as' => 'brand.'], function () {
            Route::get('/', [BrandController::class, 'index'])->name('index');
            Route::get('/create_brand', [BrandController::class, 'createBrand'])->name('manage_brand');
            Route::post('/insert', [BrandController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [BrandController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
            Route::post('/update', [BrandController::class, 'update'])->name('update');
            Route::get('/status/{status}/{id}', [BrandController::class, 'status'])->name('status');
            Route::get('/imageDelete/{pId}/{pIId}', [BrandController::class, 'imageDelete'])->name('imageDelete');
            Route::get('/select_brand', [BrandController::class, 'selectBrand'])->name('select_brand');

        });

        //--Tax Routes--//
        Route::group(['prefix' => 'tax', 'as' => 'tax.'], function () {
            Route::get('/', [TaxController::class, 'index'])->name('index');
            Route::get('/manage_tax', [TaxController::class, 'manageTax'])->name('manage_tax');
            Route::post('/insert', [TaxController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [TaxController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [TaxController::class, 'edit'])->name('edit');
            Route::get('/status/{status}/{id}', [TaxController::class, 'status'])->name('status');
            Route::get('/select_tax', [TaxController::class, 'selectTax'])->name('select_tax');
        });

        //--Customer Routes--//
        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/show/{id}', [CustomerController::class, 'show'])->name('show');
            Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('delete');
            Route::get('/status/{status}/{id}', [CustomerController::class, 'status'])->name('status');
            });

        //--Home Banner Routes--//
        Route::group(['prefix' => 'home-banner', 'as' => 'home-banner.'], function () {
            Route::get('/', [HomeBannerController::class, 'index'])->name('index');
            Route::get('/create_home_banner', [HomeBannerController::class, 'ManageHomeBanner'])->name('manage_home_banner');
            Route::post('/insert', [HomeBannerController::class, 'insert'])->name('insert');
            Route::get('/delete/{id}', [HomeBannerController::class, 'delete'])->name('delete');
            Route::get('/edit/{id}', [HomeBannerController::class, 'edit'])->name('edit');
            Route::post('/update', [HomeBannerController::class, 'update'])->name('update');
            Route::get('/status/{status}/{id}', [HomeBannerController::class, 'status'])->name('status');
            Route::get('/imageDelete/{pId}/{pIId}', [HomeBannerController::class, 'imageDelete'])->name('imageDelete');
            Route::get('/select_home_banner', [HomeBannerController::class, 'selectHomeBanner'])->name('select_banner');
        });


        Route::group(['prefix' => 'productAttribute', 'as' => 'productAttribute.'], function () {
            Route::get('/delete/{pId}/{pAId}', [ProductAttributeController::class, 'delete'])->name('delete');
        });


    });

});

//--FrontEnd Controller--//

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/product/{id}', [FrontController::class, 'product'])->name('product');

