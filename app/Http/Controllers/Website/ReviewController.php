<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreReviewRequest;
use App\Models\Review;
use App\Services\Website\ReviewService;
use Illuminate\Http\Request;
use App\Http\Resources\Website\ReviewResource;

class ReviewController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ReviewService $reviewService)
    {
        //
    }

    public function getProductReviews($productId)
    {
        $reviews = $this->reviewService->getProductReviews($productId);
        return ReviewResource::collection($reviews);
    }

    public function storeReview(StoreReviewRequest $request)
    {
        $review = $this->reviewService->createOrUpdateReview($request->validated());
        return new ReviewResource($review);
    }
}
