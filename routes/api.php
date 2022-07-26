<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\ProductsController;
use App\Http\Controllers\Api\V1\SaveForLaterController;
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

// Guest
Route::post('/register', [AuthController::class, 'register']);

// products
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{product}', [ProductsController::class, 'show']);


// categories
Route::get('categories', [CategoryController::class, 'index']);


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


// stripe
Route::post('/checkout', [CheckoutController::class, 'store']);


Route::post('/empty', function () {
    \Gloudemans\Shoppingcart\Facades\Cart::instance('shopping')->destroy();
});


// user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// admin
Route::prefix('admin')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::patch('/user/info', [AuthController::class, 'updateInfo']);
        Route::patch('/user/password', [AuthController::class, 'updatePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

});

