<?php

use App\Http\Controllers\Api\V1\AdminCategoriesController;
use App\Http\Controllers\Api\V1\AdminColorsController;
use App\Http\Controllers\Api\V1\AdminCouponsController;
use App\Http\Controllers\Api\V1\AdminOrderStatusController;
use App\Http\Controllers\Api\V1\AdminProductsController;
use App\Http\Controllers\Api\V1\AdminSlidersController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\ColorController;
use App\Http\Controllers\Api\V1\CouponController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Controllers\Api\V1\SaveForLaterController;
use App\Http\Controllers\Api\V1\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Guest

// products
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{product}', [ProductsController::class, 'show']);

// categories
Route::get('categories', [CategoryController::class, 'index']);

// sliders
Route::get('sliders', [SliderController::class, 'index']);

// colors
Route::get('colors', [ColorController::class, 'index']);


// for testing only
Route::post('/empty', function () {
    \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->destroy();
});

// user
Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('/user/info', [AuthController::class, 'updateInfo']);
    Route::patch('/user/password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // shopping cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::patch('/cart/{rowId}', [CartController::class, 'update']);
    Route::delete('/cart/{rowId}', [CartController::class, 'destroy']);
    Route::post('/cart/{rowId}/switchToSaveForLater', [CartController::class, 'switchToSaveForLater']);

    // save for later
    Route::get('/saveForLater', [SaveForLaterController::class, 'index']);
    Route::post('/saveForLater/{rowId}/switchToCart', [SaveForLaterController::class, 'switchToCart']);
    Route::delete('/saveForLater/{rowId}', [SaveForLaterController::class, 'destroy']);

    // coupons
    Route::post('coupons', [CouponController::class, 'store']);
    Route::delete('coupons', [CouponController::class, 'destroy']);

    // stripe
    Route::post('/checkout', [CheckoutController::class, 'store']);

    // orders
    Route::apiResource('/orders', OrderController::class)->only('index', 'show');
});

// admin
Route::prefix('admin')->group(function () {

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::apiResource('/products', AdminProductsController::class)->except('index', 'show');

        Route::apiResource('/categories', AdminCategoriesController::class)->except('index', 'show');

        Route::apiResource('/sliders', AdminSlidersController::class)->except('index', 'show');

        Route::middleware('can:coupons_management')->apiResource('/coupons', AdminCouponsController::class)->except('show');

        Route::middleware('can:colors_management')->apiResource('/colors', AdminColorsController::class)->except('show', 'index');

        Route::middleware('can:orders_management')->patch('orders/{order}', [AdminOrderStatusController::class, 'update']);
    });

});

