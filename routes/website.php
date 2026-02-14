<?php

use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\BeautyProfileController;
use App\Http\Controllers\Website\BeautyQuestionnaireController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\FiltersController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\ProfileController;
use App\Http\Controllers\Website\WishlistController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/items', [CartController::class, 'store']);
    Route::put('cart/items/{cartItem}', [CartController::class, 'update']);
    Route::delete('cart/items/{cartItem}', [CartController::class, 'destroy']);
    Route::post('cart/promo-code', [CartController::class, 'applyPromoCode']);

    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/paginated', [OrderController::class, 'index']);

    Route::post('beauty-profile', [BeautyProfileController::class, 'store']);
    Route::get('beauty-questionnaire', [BeautyQuestionnaireController::class, 'index']);

    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist', [WishlistController::class, 'store']); // changed to body based logic usually, but test uses URL. Let's see. 
    // Test uses: postJson("/api/wishlist/{$product->id}"); 
    // So route should be: Route::post('wishlist/{product}', 'WishlistController@store');
    Route::post('wishlist/{product}', [WishlistController::class, 'store']); 
    Route::delete('wishlist/{product}', [WishlistController::class, 'destroy']);

    Route::get('profile/addresses', [ProfileController::class, 'addresses']);
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
});

Route::group(['prefix' => 'filters'], function () {
    Route::get('categories', [FiltersController::class, 'getCategories']);
    Route::get('brands', [FiltersController::class, 'getBrands']);
    Route::get('skin-types', [FiltersController::class, 'getSkinTypes']);
    Route::get('skin-concerns', [FiltersController::class, 'getSkinConcerns']);
    Route::get('active-ingredients', [FiltersController::class, 'getActiveIngredients']);
});

Route::group(['prefix' => 'home'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('new-arrival-products', [HomeController::class, 'newArrivals']);
    Route::get('categories', [HomeController::class, 'categories']);
    Route::get('brands', [HomeController::class, 'brands']);
    Route::get('best-seller-products', [HomeController::class, 'bestSellers']);
});
