<?php

namespace App\Services\Admin;

use App\Models\SkinConcern;

class SkinConcernService
{
    public function getAllSkinConcernsPagenated($search = null)
    {
        return SkinConcern::query()
            ->search($search)
            ->paginate(10);
    }

    public function getAllSkinConcernsForSelect()
    {
       return SkinConcern::all();
    }

    public function createSkinConcern($data)
    {
        return SkinConcern::create($data);
    }

    public function getSkinConcernById($id)
    {
        return SkinConcern::findOrFail($id);
    }

    public function updateSkinConcern($id, $data)
    {
        $skinConcern = SkinConcern::findOrFail($id);
        $skinConcern->update($data);
        return $skinConcern;
    }

    public function deleteSkinConcern($id)
    {
        $skinConcern = SkinConcern::findOrFail($id);
        return $skinConcern->delete();
    }
}
