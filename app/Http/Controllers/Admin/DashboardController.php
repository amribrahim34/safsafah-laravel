<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DashboardOrdersStatusResource;
use App\Http\Resources\Admin\DashboardRevenueChartResource;
use App\Http\Resources\Admin\DashboardStatsResource;
use App\Http\Resources\Admin\DashboardTopProductResource;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $service)
    {
    }

    /**
     * GET api/admin/dashboard/stats
     *
     * Returns high-level KPI counts: users, orders, revenue, products,
     * brands, categories, and contact messages.
     */
    public function stats(): DashboardStatsResource
    {
        return new DashboardStatsResource($this->service->getStats());
    }

    /**
     * GET api/admin/dashboard/orders-status
     *
     * Returns order counts grouped by status — suitable for a pie / bar chart.
     */
    public function ordersStatus(): DashboardOrdersStatusResource
    {
        return new DashboardOrdersStatusResource($this->service->getOrdersByStatus());
    }

    /**
     * GET api/admin/dashboard/revenue-chart
     *
     * Returns monthly revenue totals for the last 6 months — suitable for a
     * line / bar chart. The response always contains exactly 6 data points,
     * with zero-filled months that had no orders.
     */
    public function revenueChart(): DashboardRevenueChartResource
    {
        return new DashboardRevenueChartResource($this->service->getRevenueChart(6));
    }

    /**
     * GET api/admin/dashboard/top-products
     *
     * Returns the top 5 best-selling products by units sold across all orders.
     */
    public function topProducts(): AnonymousResourceCollection
    {
        $items = $this->service->getTopProducts(5);

        return DashboardTopProductResource::collection($items);
    }
}
