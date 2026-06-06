<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\BlogResource;
use App\Services\Website\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(private BlogService $blogService) {}

    public function index(Request $request)
    {
        $blogs = $this->blogService->getAllBlogsPaginated(
            $request->search,
            $request->category_id,
            $request->category,
            $request->limit ?? 15
        );
        return BlogResource::collection($blogs);
    }

    public function show(string $slug)
    {
        $blog = $this->blogService->getBlogBySlug($slug);
        return new BlogResource($blog);
    }
}
