<?php

namespace App\Services\Website;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function createOrder($user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            // 1. Get User's Cart
            $cart = $user->cart()->with('items.product')->first();

            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception("Cart is empty");
            }

            // 2. Create Address
            $address = Address::create([
                'user_id' => $user->id,
                'name' => $data['customerName'],
                'details' => $data['customerAddress'],
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'notes' => $data['deliveryNotes'] ?? null,
            ]);

            // 3. Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => 0, // Will calculate
                'subtotal' => 0,
                'tax' => 0,
                'shipping' => 0,
                'discount' => 0,
                'status' => 'PENDING',
                'address_id' => $address->id,
            ]);

            // 4. Move Items and Calculate Totals
            $subtotal = 0;
            foreach ($cart->items as $cartItem) {
                $price = $cartItem->product->price;
                $total = $price * $cartItem->quantity;
                $subtotal += $total;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $price,
                    'total' => $total,
                ]);
            }

            // 5. Update Order Totals
            $order->subtotal = $subtotal;
            $order->total = $subtotal; // Add tax/shipping logic here if needed
            $order->save();

            // 6. Create Payment Record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $data['paymentType'],
                'payment_status' => 'PENDING',
                'amount' => $order->total,
                'currency' => 'SAR', // Default currency
            ]);

            // 7. Empty Cart
            $cart->items()->delete();

            return $order->load(['items.product', 'address', 'payment']);
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
