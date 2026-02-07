<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Services\FileUploadService;

class CategoryService
{

    public function __construct(private FileUploadService $fileUploadService)
    {
        
    }
    
   public function getAllCategorisPagenated($parent_id = null, $search = null)
   {
       return Category::query()
           ->parent($parent_id)
           ->search($search)
           ->paginate(10);
   }

   public function getCategoriesForSelect($parent_id = null)
   {
        return Category::query()
            ->parent($parent_id)
            ->get();
   }

   public function getParentCategoriesForSelect()
   {
        return Category::query()
            ->where('parent_id', null)
            ->get();
   }

   public function makeCategory($data)
   {
        if(isset($data['image'])){
             $data['image'] = $this->fileUploadService->upload($data['image'], 'categories');
        }
        return Category::create($data);
   }

   public function updateCategory($id, $data)
   {
        $category = Category::findOrFail($id);
        if(isset($data['image'])){
            $data['image'] = $this->fileUploadService->updateImage($category->image, $data['image'], 'categories');
        }
        $category->update($data);
        return $category;
   }

   public function deleteCategory($id)
   {
        $category = Category::findOrFail($id);
        if($category->image){
             \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
        }
        return $category->delete();
   }
}
