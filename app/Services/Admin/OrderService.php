<?php

namespace App\Services\Admin;

use App\Models\Order;

class OrderService
{
    public function getAllOrdersPagenated($search = null, $status = null)
    {
        return Order::query()
            ->with(['user', 'items.product', 'address', 'promoCode', 'payment'])
            ->search($search)
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(10);
    }

    public function getOrder($id)
    {
        return Order::with(['user', 'items.product', 'address', 'promoCode', 'payment'])->findOrFail($id);
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);
        return $order;
    }
}
