<?php

namespace App\Services\Admin;

use App\Models\PromoCode;

class PromoCodeService
{
    public function getAllPromoCodesPaginated($search = null)
    {
        return PromoCode::query()
            ->search($search)
            ->paginate(10);
    }

    public function getPromoCodeById($id)
    {
        return PromoCode::findOrFail($id);
    }

    public function createPromoCode($data)
    {
        return PromoCode::create($data);
    }

    public function updatePromoCode($id, $data)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->update($data);
        return $promoCode;
    }

    public function deletePromoCode($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return $promoCode->delete();
    }
}
