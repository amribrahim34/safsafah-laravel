<?php

namespace App\Services\Admin;

use App\Models\BeautyProfile;

class BeautyProfileService
{
    public function getAllBeautyProfilesPagenated($search = null)
    {
        // Assuming search might be on user name via relation or similar if needed in future
        return BeautyProfile::with(['user', 'skinType'])
            ->latest()
            ->paginate(10);
    }

    public function getBeautyProfile($id)
    {
        return BeautyProfile::with(['user', 'skinType'])->findOrFail($id);
    }

    // public function updateBeautyProfile($id, $data)
    // {
    //     $beautyProfile = BeautyProfile::findOrFail($id);
    //     $beautyProfile->update($data);
    //     return $beautyProfile;
    // }

    public function deleteBeautyProfile($id)
    {
        $beautyProfile = BeautyProfile::findOrFail($id);
        return $beautyProfile->delete();
    }
}
