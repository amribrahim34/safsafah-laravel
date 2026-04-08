<?php

use App\Http\Controllers\Admin\ActiveIngrediantController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BeautyProfileController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\SkinConcernController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkinTypesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    // Auth Routes
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);

        // Select endpoints (must be before apiResource)
        Route::get('brands/select', [BrandController::class, 'select']);
        Route::get('categories/select', [CategoryController::class, 'select']);
        Route::get('skin-types/select', [SkinTypesController::class, 'select']);
        Route::get('skin-concerns/select', [SkinConcernController::class, 'select']);
        Route::get('active-ingredients/select', [ActiveIngrediantController::class, 'select']);

        Route::apiResource('active-ingredients', ActiveIngrediantController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('promo-codes', PromoCodeController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('contact-messages', ContactMessageController::class);
        Route::apiResource('brands', BrandController::class);
        Route::apiResource('skin-types', SkinTypesController::class);
        Route::apiResource('skin-concerns', SkinConcernController::class);
        Route::apiResource('beauty-profiles', BeautyProfileController::class);
        Route::apiResource('orders', OrderController::class);

        // Settings (singleton resource)
        Route::get('settings', [SettingController::class, 'show']);
        Route::put('settings', [SettingController::class, 'update']);
    });
});
