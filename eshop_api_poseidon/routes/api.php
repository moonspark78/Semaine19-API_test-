<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/test', function () {
    return [
        "message" => "Bienvenue sur l'API eshop Poseidon ! :)",
    ];
});

Route::get('/test-response', function () {
    return response()->json([
        'message' => 'Bonjour depuis l\'API'
    ], 201);
});


Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{product}', [
    ProductController::class,
    'show'
]);




Route::get('/categories', [
    CategoryController::class,
    'index'
]);

Route::get('/categories/{category}', [
    CategoryController::class,
    'show'
]);




Route::post('/register', [
    AuthController::class,
    'register'
]);

Route::post('/login', [
    AuthController::class,
    'login'
]);



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::get('/profile', function (Request $request) {
        return $request->user();
    });


 

    // Voir ses propres commandes
    Route::get('/orders', [
        OrderController::class,
        'index'
    ]);


    // Voir une de ses commandes
    Route::get('/orders/{order}', [
        OrderController::class,
        'show'
    ]);


    // Créer une commande
    Route::post('/orders', [
        OrderController::class,
        'store'
    ]);


 

    Route::delete('/logout', [
        AuthController::class,
        'logout'
    ]);

});




Route::middleware([
    'auth:sanctum',
    'admin'
])->group(function () {

    // Créer un produit
    Route::post('/products', [
        ProductController::class,
        'store'
    ]);


    // Voir toutes les commandes
    Route::get('/admin/orders', [
        OrderController::class,
        'adminIndex'
    ]);


    // Modifier le statut d'une commande
    Route::patch('/admin/orders/{order}', [
        OrderController::class,
        'updateStatus'
    ]);

});




Route::get('/limit', function () {
    return [
        "message" => "Je suis limité ?",
    ];
})->middleware('throttle:api');