<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Website\Order\StoreOrderRequest;
use App\Http\Resources\Website\OrderResource;
use App\Services\Website\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('size', 10);
        $orders = $this->orderService->getOrders($request->user(), $perPage);
        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->user(), $request->validated());
            return new OrderResource($order);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }}
