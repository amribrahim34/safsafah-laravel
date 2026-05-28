<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Order\GuestOrderRequest;
use App\Http\Requests\Website\Order\StoreOrderRequest;
use App\Http\Resources\Website\OrderResource;
use App\Http\Resources\Website\UserResource;
use App\Services\Website\OrderService;
use App\Services\Website\Orders\GuestOrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected GuestOrderService $guestOrderService,
    ) {
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
    }

    public function show(Request $request, $id)
    {
        try {
            $order = $this->orderService->getOrderById($id, $request->user()->id);
            return new OrderResource($order);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function cancel(Request $request, $id)
    {
        try {
            $this->orderService->cancelOrder($id, $request->user()->id);
            return response()->json(['message' => __('messages.order_canceled')]);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function guestOrder(GuestOrderRequest $request)
    {
        try {
            $result = $this->guestOrderService->create($request->validated());
            return response()->json([
                'user'  => new UserResource($result['user']),
                'order' => new OrderResource($result['order']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
