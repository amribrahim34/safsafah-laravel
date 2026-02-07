<?php

namespace App\Services\Admin;

use App\Models\Brand;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    public function __construct(private FileUploadService $fileUploadService)
    {
    }

    public function getAllBrandsPagenated($search = null)
    {
        return Brand::query()
            ->search($search)
            ->paginate(10);
    }

    public function getAllBrandsForSelect()
    {
        return Brand::all();
    }

    public function createBrand($data)
    {
        if (isset($data['logo'])) {
            $data['logo'] = $this->fileUploadService->upload($data['logo'], 'brands');
        }
        return Brand::create($data);
    }

    public function updateBrand($id, $data)
    {
        $brand = Brand::findOrFail($id);
        if (isset($data['logo'])) {
            $data['logo'] = $this->fileUploadService->updateImage($brand->logo, $data['logo'], 'brands');
        }
        $brand->update($data);
        return $brand;
    }

    public function getBrandById($id)
    {
        return Brand::findOrFail($id);
    }

    public function deleteBrand($id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }
        return $brand->delete();
    }
}
