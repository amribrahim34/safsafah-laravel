<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;
use App\Http\Requests\Admin\GetOrdersRequest;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Resources\Admin\OrderResource;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetOrdersRequest $request)
    {
        $orders = $this->orderService->getAllOrdersPagenated($request->search, $request->status);
        return OrderResource::collection($orders);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = $this->orderService->getOrder($id);
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        $order = $this->orderService->updateOrderStatus($id, $request->status);
        return new OrderResource($order);
    }
}
