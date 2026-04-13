<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(private FileUploadService $fileUploadService)
    {
    }

    public function getAllProductsPaginated($search = null, $category_id = null, $brand_id = null)
    {
        return Product::query()
            ->search($search)
            ->when($category_id, fn($q) => $q->where('category_id', $category_id))
            ->when($brand_id, fn($q) => $q->where('brand_id', $brand_id))
            ->with(['category', 'brand' , 'activeIngredients' , 'skinTypes' , 'skinConcerns'])
            ->latest()
            ->paginate(30);
    }

    public function getProductById($id)
    {
        return Product::with(['category', 'brand' , 'activeIngredients' , 'skinTypes' , 'skinConcerns'])->findOrFail($id);
    }

    public function createProduct($data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->fileUploadService->upload($data['image'], 'products' , $data['name_en']);
        }

        $data['slug_ar'] = arabic_slug($data['name_ar']);
        $data['slug_en'] = Str::slug($data['name_en']);

        $product = Product::create($data);

        $this->syncRelations($product, $data);

        return $product;
    }

    public function updateProduct($id, $data)
    {
        $product = Product::findOrFail($id);

        if (isset($data['image'])) {
            Log::info('Updating product image for product ID: ' . $id,['method' => __METHOD__]);
            $data['image'] = $this->fileUploadService->updateImage($product->image, $data['image'], 'products' , $data['name_en']);
        }

        isset($data['name_ar']) ? $data['slug_ar'] = arabic_slug($data['name_ar']) : null;
        isset($data['name_en']) ? $data['slug_en'] = Str::slug($data['name_en']) : null;

        $product->update($data);

        $this->syncRelations($product, $data);

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        return $product->delete();
    }

    private function syncRelations(Product $product, array $data)
    {
        if (isset($data['active_ingredients'])) {
            $product->activeIngredients()->sync($data['active_ingredients']);
        }
        if (isset($data['skin_types'])) {
            $product->skinTypes()->sync($data['skin_types']);
        }
        if (isset($data['skin_concerns'])) {
            $product->skinConcerns()->sync($data['skin_concerns']);
        }
    }
}
