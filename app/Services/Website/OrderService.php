<?php

namespace App\Services\Website;

use App\Enums\OrderStatusEnum;
use App\Events\OrderCreated;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\Website\Orders\OrderCalculationService;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private OrderCalculationService $calculationService)
    {
    }

    public function createOrder($user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            // 1. Get User's Cart
            $cart = $user->cart()->with('items.product', 'promoCode')->first();

            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception("Cart is empty");
            }

            // 2. Calculate totals (validates promo code if present)
            $totals = $this->calculationService->calculate($cart->items, $cart->promoCode);

            // 3. Create Address
            $address = Address::create([
                'user_id' => $user->id,
                'name' => $data['customerName'],
                'details' => $data['customerAddress'],
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'notes' => $data['deliveryNotes'] ?? null,
            ]);

            // 4. Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $totals['subtotal'],
                'discount' => $totals['discount'],
                'tax' => $totals['tax'],
                'shipping' => $totals['shipping'],
                'total' => $totals['total'],
                'status' => OrderStatusEnum::PENDING->value,
                'address_id' => $address->id,
                'promo_code_id' => $cart->promo_code_id,
            ]);

            // 5. Create Order Items
            foreach ($cart->items as $cartItem) {
                $price = $cartItem->product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $price,
                    'total' => $price * $cartItem->quantity,
                ]);
            }

            // 6. Create Payment Record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $data['paymentType'],
                'payment_status' => 'PENDING',
                'amount' => $order->total,
                'currency' => 'SAR',
            ]);

            // 7. Increment promo code usage
            if ($cart->promoCode) {
                $cart->promoCode->increment('times_used');
            }

            // 8. Clear Cart
            $cart->items()->delete();
            $cart->update(['promo_code_id' => null]);

            $order = $order->load(['items.product', 'address', 'payment']);

            OrderCreated::dispatch($order);

            return $order;
        });
    }

    public function getOrders($user, $perPage = 10)
    {
        return Order::where('user_id', $user->id)
            ->with(['items.product', 'payment', 'address'])
            ->latest()
            ->paginate($perPage);
    }
}
