<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogCategoryRequest;
use App\Http\Requests\Admin\UpdateBlogCategoryRequest;
use App\Http\Resources\Admin\BlogCategoryResource;
use App\Services\Admin\BlogCategoryService;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function __construct(private BlogCategoryService $blogCategoryService) {}

    public function select()
    {
        $categories = $this->blogCategoryService->getForSelect();
        return BlogCategoryResource::collection($categories);
    }

    public function index(Request $request)
    {
        $categories = $this->blogCategoryService->getAllPaginated($request->search);
        return BlogCategoryResource::collection($categories);
    }

    public function store(StoreBlogCategoryRequest $request)
    {
        $category = $this->blogCategoryService->create($request->validated());
        return new BlogCategoryResource($category);
    }

    public function show(string $id)
    {
        $category = $this->blogCategoryService->getById($id);
        return new BlogCategoryResource($category);
    }

    public function update(UpdateBlogCategoryRequest $request, string $id)
    {
        $category = $this->blogCategoryService->update($id, $request->validated());
        return new BlogCategoryResource($category);
    }

    public function destroy(string $id)
    {
        $this->blogCategoryService->delete($id);
        return response()->noContent();
    }
}
