<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private readonly ?string $search = null,
        private readonly ?string $filter = null,
    ) {}

    /** Build the base query (same scopes as the paginated listing). */
    public function query()
    {
        return User::query()
            ->withCount('orders')
            ->search($this->search)
            ->when($this->filter === 'has_orders',          fn ($q) => $q->hasOrders())
            ->when($this->filter === 'no_orders',           fn ($q) => $q->noOrders())
            ->when($this->filter === 'has_beauty_profile',  fn ($q) => $q->hasBeautyProfile())
            ->orderByDesc('orders_count');
    }

    /** Column headers. */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Mobile',
            'Points',
            'Orders Count',
            'Registered At',
        ];
    }

    /** Map each row to the exported columns. */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->mobile,
            $user->points,
            $user->orders_count,
            $user->created_at?->toDateTimeString(),
        ];
    }

    /** Bold the header row. */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
