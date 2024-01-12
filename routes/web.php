<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', [AdminController::class, 'index']);
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');

Route::group(['middleware'=> 'admin_auth'],function(){

    Route::get('admin/logout', function(){
        session()->forget('ADMIN.LOGIN');
        session()->forget('ADMIN.ID');
        session()->flash('error', 'Logout Successful');
        return redirect('admin');
    })->name('admin.logout');

    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('admin/category/manage_category', [CategoryController::class, 'manage_category'])->name('manage_category');
    Route::get('admin/category/manage_category/{id}', [CategoryController::class, 'manage_category'])->name('manage_category');
    Route::post('admin/category/manage_category_process', [CategoryController::class, 'manage_category_process'])->name('category.manage_category_process');
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
//
    Route::get('admin/coupon', [CouponController::class, 'index'])->name('admin.coupon');
    Route::get('admin/coupon/manage_coupon', [CouponController::class, 'manage_coupon'])->name('manage_coupon');
    Route::get('admin/coupon/manage_coupon/{id}', [CouponController::class, 'manage_coupon'])->name('manage_coupon');
    Route::post('admin/coupon/manage_coupon_process', [CouponController::class, 'manage_coupon_process'])->name('coupon.manage_coupon_process');
    Route::get('admin/coupon/delete/{id}', [CouponController::class, 'delete'])->name('delete');


});

