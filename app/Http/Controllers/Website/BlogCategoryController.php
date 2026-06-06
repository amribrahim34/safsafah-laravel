<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\BlogCategoryResource;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::query()
            ->search($request->search)
            ->get();

        return BlogCategoryResource::collection($categories);
    }
}
