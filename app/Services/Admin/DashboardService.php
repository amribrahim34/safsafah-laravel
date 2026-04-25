<?php

namespace App\Services\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ContactMessages;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * High-level KPI snapshot for the summary stats widget.
     * All queries are single aggregation calls — no N+1 risk.
     */
    public function getStats(): array
    {
        $now = now();

        return [
            'users' => [
                'total'          => User::count(),
                'new_this_month' => User::whereYear('created_at', $now->year)
                                        ->whereMonth('created_at', $now->month)
                                        ->count(),
            ],
            'orders' => [
                'total'      => Order::count(),
                'this_month' => Order::whereYear('created_at', $now->year)
                                     ->whereMonth('created_at', $now->month)
                                     ->count(),
                'pending'    => Order::where('status', 'pending')->count(),
            ],
            'revenue' => [
                'total'      => (float) Order::sum('total'),
                'this_month' => (float) Order::whereYear('created_at', $now->year)
                                              ->whereMonth('created_at', $now->month)
                                              ->sum('total'),
            ],
            'products'         => ['total' => Product::count()],
            'brands'           => ['total' => Brand::count()],
            'categories'       => ['total' => Category::count()],
            'contact_messages' => ['total' => ContactMessages::count()],
        ];
    }

    /**
     * Order counts grouped by status for the status-breakdown widget.
     * Returns an associative array keyed by status name.
     */
    public function getOrdersByStatus(): array
    {
        $rows = Order::query()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Ensure all known statuses are present even if count is 0
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

        return collect($statuses)
            ->mapWithKeys(fn (string $s) => [$s => (int) ($rows[$s] ?? 0)])
            ->all();
    }

    /**
     * Monthly revenue totals for the last N months (default 6).
     * Suitable for rendering a line / bar chart on the frontend.
     */
    public function getRevenueChart(int $months = 6): array
    {
        $from = now()->subMonths($months - 1)->startOfMonth();

        $rows = Order::query()
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as revenue')
            )
            ->where('created_at', '>=', $from)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Build a complete month list so the frontend always gets N data points,
        // filling in zero for months with no orders.
        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $label = now()->subMonths($i)->format('Y-m');
            $result[] = [
                'month'   => $label,
                'revenue' => (float) ($rows[$label]->revenue ?? 0),
            ];
        }

        return $result;
    }

    /**
     * Top N best-selling products by total quantity sold across all orders.
     * Eagerly loads the product relationship to avoid N+1.
     */
    public function getTopProducts(int $limit = 5): Collection
    {
        return OrderItem::query()
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->with('product')           // eager-load to avoid N+1
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
}
