<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardOrdersStatusResource extends JsonResource
{
    /**
     * The resource wraps an associative array keyed by order status.
     * e.g. ['pending' => 34, 'confirmed' => 120, ...]
     *
     * @return array<string, int>
     */
    public function toArray(Request $request): array
    {
        return [
            'pending'    => $this->resource['pending']    ?? 0,
            'confirmed'  => $this->resource['confirmed']  ?? 0,
            'processing' => $this->resource['processing'] ?? 0,
            'shipped'    => $this->resource['shipped']    ?? 0,
            'delivered'  => $this->resource['delivered']  ?? 0,
            'cancelled'  => $this->resource['cancelled']  ?? 0,
        ];
    }
}
