<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers\Website'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

Route::group(['namespace' => 'App\Http\Controllers\Website'], function () {
    Route::get('products', 'ProductController@index');
    Route::get('products/{product}', 'ProductController@show');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('cart', 'CartController@index');
        Route::post('cart/items', 'CartController@store');
        Route::put('cart/items/{cartItem}', 'CartController@update');
        Route::delete('cart/items/{cartItem}', 'CartController@destroy');
        Route::post('cart/promo-code', 'CartController@applyPromoCode');

        Route::post('orders', 'OrderController@store');
        Route::get('orders/paginated', 'OrderController@index');

        Route::post('beauty-profile', 'BeautyProfileController@store');
        Route::get('beauty-questionnaire', 'BeautyQuestionnaireController@index');

        Route::get('wishlist', 'WishlistController@index');
        Route::post('wishlist', 'WishlistController@store'); // changed to body based logic usually, but test uses URL. Let's see. 
        // Test uses: postJson("/api/wishlist/{$product->id}"); 
        // So route should be: Route::post('wishlist/{product}', 'WishlistController@store');
        Route::post('wishlist/{product}', 'WishlistController@store'); 
        Route::delete('wishlist/{product}', 'WishlistController@destroy');

        Route::get('profile/addresses', 'ProfileController@addresses');
        Route::get('profile', 'ProfileController@show');
        Route::put('profile', 'ProfileController@update');
    });

    Route::group(['prefix' => 'home'], function () {
        Route::get('/', 'HomeController@index');
        Route::get('new-arrival-products', 'HomeController@newArrivals');
        Route::get('categories', 'HomeController@categories');
        Route::get('brands', 'HomeController@brands');
        Route::get('best-seller-products', 'HomeController@bestSellers');
    });
});

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
