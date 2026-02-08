<?php

namespace App\Services\Website;

use App\Models\Address;

class ProfileService
{
    /**
     * Create a new class instance.
     */
    public function getProfile($user)
    {
        return $user;
    }

    public function updateProfile($user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function getAddresses($user)
    {
        return Address::where('user_id', $user->id)->get();
    }
}
