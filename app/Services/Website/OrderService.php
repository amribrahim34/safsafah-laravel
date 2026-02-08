<?php

namespace App\Services\Website;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function createOrder($user, array $data)
    {
        // 1. Get User's Cart
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new Exception("Cart is empty");
        }

        // 2. Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => 0, // Will calculate
            'subtotal' => 0,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'status' => 'PENDING',
            'address_id' => null, // logic to handle address creation/assignment
            // We might need to store the raw address details if no address_id is provided, 
            // but the Table schema for orders might expect address_id. 
            // The request has 'customerAddress'. We can create an Address or store it in JSON/Text if column exists.
            // For now, assuming we create a new Address or use existing.
        ]);
        
        // Handle Address - Simplification for now: Create new address or find existing
        // In a real app, we'd check if specific address_id was passed or create one from details.
        // The Request passes 'customerAddress' string.
        $address = Address::create([
            'user_id' => $user->id,
            'name' => $data['customerName'],
            'details' => $data['customerAddress'],
             // 'mobile' => $data['customerMobile'], // Address model doesn't have mobile, User does.
             // We can ignore mobile for address or update user.
        ]);
        $order->address_id = $address->id;

        // 3. Move Items
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

        // 4. Update Order Totals
        $order->subtotal = $subtotal;
        $order->total = $subtotal; // + tax + shipping - discount
        $order->save();

        // 5. Empty Cart
        $cart->items()->delete();
        // $cart->delete(); // Or keep empty cart

        return $order->load('items.product');
    }

    public function getOrders($user, $perPage = 10)
    {
        return Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->paginate($perPage);
    }
}
