<?php

namespace App\Services\Website\Orders;

use App\Enums\OrderStatusEnum;
use App\Events\OrderCreated;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuestOrderService
{
    public function __construct(private OrderCalculationService $calculationService)
    {
    }

    public function create(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // 1. Find or create user by mobile
            $user = User::firstOrCreate(
                ['mobile' => $data['customerMobile']],
                [
                    'name'     => $data['customerName'],
                    'password' => Hash::make('safsafah123'),
                ]
            );

            // 2. Load products and build items collection for calculation
            $products = Product::whereIn('id', array_column($data['items'], 'product_id'))
                ->get()
                ->keyBy('id');

            $items = collect($data['items'])->map(fn($item) => (object)[
                'product'    => $products[$item['product_id']],
                'quantity'   => $item['quantity'],
                'product_id' => $item['product_id'],
            ]);

            // 3. Calculate totals
            $totals = $this->calculationService->calculate($items);

            // 4. Create address
            $address = Address::create([
                'user_id'   => $user->id,
                'name'      => $data['customerName'],
                'details'   => $data['customerAddress'],
                'latitude'  => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'notes'     => $data['deliveryNotes'] ?? null,
            ]);

            // 5. Create order
            $order = Order::create([
                'user_id'   => $user->id,
                'subtotal'  => $totals['subtotal'],
                'discount'  => $totals['discount'],
                'tax'       => $totals['tax'],
                'shipping'  => $totals['shipping'],
                'total'     => $totals['total'],
                'status'    => OrderStatusEnum::PENDING->value,
                'address_id' => $address->id,
            ]);

            // 6. Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->product->price,
                    'total'      => $item->product->price * $item->quantity,
                ]);
            }

            // 7. Create payment record
            Payment::create([
                'order_id'       => $order->id,
                'payment_method' => $data['paymentType'],
                'payment_status' => 'PENDING',
                'amount'         => $order->total,
                'currency'       => 'SAR',
            ]);

            $order = $order->load(['items.product', 'address', 'payment']);

            OrderCreated::dispatch($order);

            return ['user' => $user, 'order' => $order];
        });
    }
}
