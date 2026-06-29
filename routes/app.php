<?php

use App\Http\Controllers\App\AuthController;
use App\Http\Controllers\App\BeautyProfileController;
use App\Http\Controllers\App\BeautyQuestionnaireController;
use App\Http\Controllers\App\BlogCategoryController;
use App\Http\Controllers\App\BlogController;
use App\Http\Controllers\App\CartController;
use App\Http\Controllers\App\FiltersController;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\App\OrderController;
use App\Http\Controllers\App\ProductController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\ReviewController;
use App\Http\Controllers\App\SettingController;
use App\Http\Controllers\App\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mobile Application Routes
|--------------------------------------------------------------------------
| Routes consumed by the mobile application. Loaded under the "api" prefix
| (see routes/api.php) and grouped here under the "app" prefix, so all
| endpoints live at /api/app/...
*/

Route::group(['prefix' => 'app'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::get('settings', [SettingController::class, 'show']);

    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blogs/{slug}', [BlogController::class, 'show']);
    Route::get('blog-categories', [BlogCategoryController::class, 'index']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);
    Route::get('products/{product}/reviews', [ReviewController::class, 'getProductReviews']);

    Route::post('orders/guest', [OrderController::class, 'guestOrder']);

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::post('reviews', [ReviewController::class, 'storeReview']);

        Route::get('cart', [CartController::class, 'index']);
        Route::post('cart/items', [CartController::class, 'store']);
        Route::put('cart/items/{cartItem}', [CartController::class, 'update']);
        Route::delete('cart/items/{cartItem}', [CartController::class, 'destroy']);
        Route::post('cart/promo-code', [CartController::class, 'applyPromoCode']);

        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders/paginated', [OrderController::class, 'index']);
        Route::get('orders/{id}', [OrderController::class, 'show']);
        Route::post('orders/{id}/cancel', [OrderController::class, 'cancel']);

        Route::post('beauty-profile', [BeautyProfileController::class, 'store']);
        Route::get('beauty-profile', [BeautyProfileController::class, 'show']);
        Route::get('beauty-questionnaire', [BeautyQuestionnaireController::class, 'index']);

        Route::get('wishlist', [WishlistController::class, 'index']);
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
});
