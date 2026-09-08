<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function() {
    return [
        "message" => "Bienvenue sur l'API eshop Poseidon ! :)",
    ];
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);




Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/test-response', function(){
    return response()->json([
        'message' => 'Bonjour depuis l\'API'
    ], 201);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::get('/profile', function (Request $request){
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {

Route::get('/profile', function (Request $request){return $request->user();});
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::delete('/logout', [AuthController::class, 'logout']);

});

Route::middleware(['auth:sanctum', 'admin'])->group(function() {
    Route::post('/products', [ProductController::class, 'store']);
});

Route::get('/limit', function () {
    return [
        "message" => "Je suis limité ?",
    ];
})->middleware('throttle:api');

