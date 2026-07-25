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
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ChangePasswordController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\PostController as ClientPostController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{slug}', [ClientProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('brand');
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');

// Tin Tức phía Client
Route::get('/posts', [ClientPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [ClientPostController::class, 'show'])->name('posts.show');

Route::prefix('cart')->controller(CartController::class)->name('cart.')->group(function () { 
    Route::get('/show', 'show')->name('show'); 
    Route::post('/add/{id}', 'addToCart')->name('add'); 
    Route::delete('/remove/{id}', 'removeCart')->name('remove'); 

    Route::post('/checkout', 'checkout')->name('checkout'); 
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

            // Thùng rác và khôi phục của Brands
            Route::get('trash/brands', [BrandController::class, 'trash'])->name('brands.trash');
            Route::patch('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
            Route::delete('brands/{id}/forcedelete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');

            // Thùng rác và khôi phục của Products
            Route::get('trash/products', [ProductController::class, 'trash'])->name('products.trash');
            Route::patch('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
            Route::delete('products/{id}/forcedelete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

            // Thùng rác và khôi phục của Users
            Route::get('trash/users', [UserController::class, 'trash'])->name('users.trash');
            Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
            Route::delete('users/{id}/forcedelete', [UserController::class, 'forceDelete'])->name('users.forceDelete');

            // Thùng rác và khôi phục của Posts
            Route::get('trash/posts', [PostController::class, 'trash'])->name('posts.trash');
            Route::patch('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
            Route::delete('posts/{id}/forcedelete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');

            Route::resource('categories', CategoryController::class);
            Route::resource('brands', BrandController::class);
            Route::resource('users', UserController::class);
            Route::resource('posts', PostController::class);

            // Các hành động thay đổi sản phẩm (Create, Store, Edit, Update, Destroy)
            Route::resource('products', ProductController::class)->except(['index']);
            Route::post('products/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('products.delete-image');

            // Quản lý đơn hàng
            Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
            Route::post('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::post('orders/bulk-status', [AdminOrderController::class, 'bulkStatus'])->name('orders.bulkStatus');

            // Đổi mật khẩu Admin có gửi mail Gmail
            Route::get('change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password.form');
            Route::post('change-password', [ChangePasswordController::class, 'updatePassword'])->name('change-password.update');
        });

        // Nhân viên (role = 2) và Admin (role = 1) đều được phép xem danh sách sản phẩm
        Route::resource('products', ProductController::class)->only(['index'])->middleware('roles:1,2');
    });
});
Route::get('/test-500', function () {
    abort(500);
});
