<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return [
        'version' => '1.0.0'
    ];
});

//                                                                                       \/ ตรงนี้คือชื่อฟังก์ชัน ใส่อยู่กับคลาส จะได้รู้ว่า route นี้ไปทำงานที่ไหน
Route::get('/rewards/search', [\App\Http\Controllers\Api\RewardController::class, 'search']);
Route::get('/reward_codes/search', [\App\Http\Controllers\Api\RewardCodeController::class, 'search']);
Route::apiResource('/rewards', \App\Http\Controllers\Api\RewardController::class);
Route::apiResource('/reward_codes', \App\Http\Controllers\Api\RewardCodeController::class);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::get('/products/search', [\App\Http\Controllers\Api\ProductController::class, 'search']);
Route::apiResource('/products', \App\Http\Controllers\Api\ProductController::class);

Route::get('/shops/search', [\App\Http\Controllers\Api\ShopController::class, 'search']);
Route::apiResource('/shops', \App\Http\Controllers\Api\ShopController::class);

Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class]);
Route::apiResource('/categories', \App\Http\Controllers\Api\CategoryController::class);

Route::get('/orders/search', [\App\Http\Controllers\Api\OrderController::class, 'search']);
Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class]);
Route::apiResource('/orders', \App\Http\Controllers\Api\OrderController::class);

Route::get('/order-items', [\App\Http\Controllers\Api\OrderItemController::class]);
Route::apiResource('/order-items', \App\Http\Controllers\Api\OrderItemController::class);

Route::get('/baskets', [\App\Http\Controllers\Api\BasketController::class]);
Route::apiResource('/baskets', \App\Http\Controllers\Api\BasketController::class);

Route::get('/basket-item', [\App\Http\Controllers\Api\BasketItemController::class]);
Route::apiResource('/basket-item', \App\Http\Controllers\Api\BasketItemController::class);

Route::get('/comments', [\App\Http\Controllers\Api\CommentController::class]);
Route::apiResource('/comments', \App\Http\Controllers\Api\CommentController::class);

Route::get('/images/search', [\App\Http\Controllers\Api\ImageController::class, 'search']);
Route::post('/images', [\App\Http\Controllers\Api\ImageController::class, 'store']);
