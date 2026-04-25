<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardRevenueChartResource extends JsonResource
{
    /**
     * The resource wraps an array of month/revenue entries.
     * e.g. [['month' => '2026-03', 'revenue' => 41000.0], ...]
     *
     * We use a collection resource to output the array as the `data` key.
     *
     * @return array<int, array<string, mixed>>
     */
    public function toArray(Request $request): array
    {
        // $this->resource is already the full array of month entries;
        // map over it to enforce the exact shape and cast types.
        return collect($this->resource)->map(fn (array $entry) => [
            'month'   => $entry['month'],
            'revenue' => (float) $entry['revenue'],
        ])->values()->all();
    }
}
