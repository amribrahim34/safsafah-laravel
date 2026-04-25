<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatsResource extends JsonResource
{
    /**
     * The resource is an associative array (not an Eloquent model),
     * so we cast $this to array access via the underlying ArrayAccess implementation.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'users' => [
                'total'          => $this['users']['total'],
                'new_this_month' => $this['users']['new_this_month'],
            ],
            'orders' => [
                'total'      => $this['orders']['total'],
                'this_month' => $this['orders']['this_month'],
                'pending'    => $this['orders']['pending'],
            ],
            'revenue' => [
                'total'      => $this['revenue']['total'],
                'this_month' => $this['revenue']['this_month'],
            ],
            'products'         => ['total' => $this['products']['total']],
            'brands'           => ['total' => $this['brands']['total']],
            'categories'       => ['total' => $this['categories']['total']],
            'contact_messages' => ['total' => $this['contact_messages']['total']],
        ];
    }
}
