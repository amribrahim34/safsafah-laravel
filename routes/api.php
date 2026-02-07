<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->group(function () {
    // Auth Routes
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
        Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout']);
        Route::get('me', [\App\Http\Controllers\Admin\AuthController::class, 'me']);

        // Select endpoints (must be before apiResource)
        Route::get('brands/select', [\App\Http\Controllers\Admin\BrandController::class, 'select']);
        Route::get('categories/select', [\App\Http\Controllers\Admin\CategoryController::class, 'select']);
        Route::get('skin-types/select', [\App\Http\Controllers\Admin\SkinTypesController::class, 'select']);
        Route::get('skin-concerns/select', [\App\Http\Controllers\Admin\SkinConcernController::class, 'select']);
        Route::get('active-ingredients/select', [\App\Http\Controllers\Admin\ActiveIngrediantController::class, 'select']);

        Route::apiResource('active-ingredients', \App\Http\Controllers\Admin\ActiveIngrediantController::class);
        Route::apiResource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::apiResource('promo-codes', \App\Http\Controllers\Admin\PromoCodeController::class);
        Route::apiResource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::apiResource('contact-messages', \App\Http\Controllers\Admin\ContactMessageController::class);
        Route::apiResource('brands', \App\Http\Controllers\Admin\BrandController::class);
        Route::apiResource('skin-types', \App\Http\Controllers\Admin\SkinTypesController::class);
        Route::apiResource('skin-concerns', \App\Http\Controllers\Admin\SkinConcernController::class);
        Route::apiResource('beauty-profiles', \App\Http\Controllers\Admin\BeautyProfileController::class);
        Route::apiResource('orders', \App\Http\Controllers\Admin\OrderController::class);
    });
});
