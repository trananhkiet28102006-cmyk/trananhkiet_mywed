<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;

Route::get('/', function () {
    return 'hello word';
});

Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{param1}/{param2}', [DemoController::class, 'index6']);

Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication công khai (chưa đăng nhập)
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postForgotPassword'])->name('forgotpass.post');

    // Tuyến đường yêu cầu đăng nhập
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [AuthController::class, 'postChangePassword'])->name('change-password.post');

        // Các tuyến đường chỉ dành cho Admin (role = 1)
        Route::middleware('roles:1')->group(function () {
            // Thùng rác và khôi phục của Categories
            Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
            Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
            Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

            Route::resource('categories', CategoryController::class);
            Route::resource('brands', BrandController::class);
            Route::resource('users', UserController::class);
            Route::resource('posts', PostController::class);

            // Các hành động thay đổi sản phẩm (Create, Store, Edit, Update, Destroy)
            Route::resource('products', ProductController::class)->except(['index']);
            Route::post('products/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
        });

        // Nhân viên (role = 2) và Admin (role = 1) đều được phép xem danh sách sản phẩm
        Route::resource('products', ProductController::class)->only(['index'])->middleware('roles:1,2');
    });
});
Route::get('/test-500', function () {
    abort(500);
});
