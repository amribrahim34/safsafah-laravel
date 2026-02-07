<?php

namespace App\Services\Admin;

use App\Models\ActiveIngredient;

class ActiveIngrediantService
{
    public function getAllActiveIngredientsPagenated($search = null)
    {
        return ActiveIngredient::query()
            ->search($search)
            ->paginate(10);
    }

    public function getAllActiveIngredientsForSelect()
    {
        return ActiveIngredient::all();
    }

    public function createActiveIngredient($data)
    {
        return ActiveIngredient::create($data);
    }

    public function updateActiveIngredient($id, $data)
    {
        $activeIngredient = ActiveIngredient::findOrFail($id);
        $activeIngredient->update($data);
        return $activeIngredient;
    }

    public function deleteActiveIngredient($id)
    {
        $activeIngredient = ActiveIngredient::findOrFail($id);
        return $activeIngredient->delete();
    }

    public function getActiveIngredientById($id)
    {
        return ActiveIngredient::findOrFail($id);
    }
}
