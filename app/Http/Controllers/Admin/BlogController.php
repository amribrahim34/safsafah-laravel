<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Http\Resources\Admin\BlogResource;
use App\Services\Admin\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(private BlogService $blogService) {}

    public function index(Request $request)
    {
        $blogs = $this->blogService->getAllBlogsPaginated($request->search);
        return BlogResource::collection($blogs);
    }

    public function store(StoreBlogRequest $request)
    {
        $blog = $this->blogService->createBlog($request->validated());
        return new BlogResource($blog);
    }

    public function show(string $id)
    {
        $blog = $this->blogService->getBlogById($id);
        return new BlogResource($blog);
    }

    public function update(UpdateBlogRequest $request, string $id)
    {
        $blog = $this->blogService->updateBlog($id, $request->validated());
        return new BlogResource($blog);
    }

    public function destroy(string $id)
    {
        $this->blogService->deleteBlog($id);
        return response()->noContent();
    }
}
