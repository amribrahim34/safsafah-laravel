<?php

namespace App\Services\Admin;

use App\Models\SkinType;

class SkinTypeService
{
    public function getAllSkinTypesPagenated($search = null)
    {
        return SkinType::query()
            ->search($search)
            ->paginate(10);
    }

    public function getAllSkinTypesForSelect()
    {
       return SkinType::all();
    }

    public function createSkinType($data)
    {
        return SkinType::create($data);
    }

    public function updateSkinType($id, $data)
    {
        $skinType = SkinType::findOrFail($id);
        $skinType->update($data);
        return $skinType;
    }

    public function deleteSkinType($id)
    {
        $skinType = SkinType::findOrFail($id);
        return $skinType->delete();
    }
}
