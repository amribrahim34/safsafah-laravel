<?php

namespace App\Services\Website;

use App\Models\Review;

class ReviewService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getProductReviews($productId)
    {
        return Review::where('product_id', $productId)
        ->with('user')
        ->paginate(10);
    }

    public function createOrUpdateReview(array $data)
    {
        return Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $data['product_id']
            ],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null
            ]
        );
    }
}
