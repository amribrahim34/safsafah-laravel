<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4;padding:30px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

                {{-- Header --}}
                <tr>
                    <td style="background-color:#1a1a2e;padding:32px 40px;text-align:center;">
                        <h1 style="margin:0;color:#ffffff;font-size:28px;font-weight:700;letter-spacing:2px;">SAFSAFAH</h1>
                        <p style="margin:6px 0 0;color:#a0a0c0;font-size:13px;letter-spacing:1px;">ORDER CONFIRMATION</p>
                    </td>
                </tr>

                {{-- Success Banner --}}
                <tr>
                    <td style="background-color:#e8f5e9;padding:20px 40px;text-align:center;border-bottom:1px solid #c8e6c9;">
                        <p style="margin:0;font-size:16px;color:#2e7d32;font-weight:600;">
                            ✓ &nbsp;Your order has been placed successfully!
                        </p>
                    </td>
                </tr>

                {{-- Greeting --}}
                <tr>
                    <td style="padding:32px 40px 0;">
                        <p style="margin:0;font-size:16px;color:#333333;">
                            Hello, <strong>{{ $order->user->name ?? 'Valued Customer' }}</strong>!
                        </p>
                        <p style="margin:10px 0 0;font-size:14px;color:#666666;line-height:1.6;">
                            Thank you for shopping with Safsafah. We've received your order and it's currently being processed.
                            You'll receive another update once it ships.
                        </p>
                    </td>
                </tr>

                {{-- Order Meta --}}
                <tr>
                    <td style="padding:24px 40px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8f9fa;border-radius:6px;border:1px solid #e9ecef;">
                            <tr>
                                <td style="padding:16px 20px;border-right:1px solid #e9ecef;" width="33%">
                                    <p style="margin:0;font-size:11px;color:#999999;text-transform:uppercase;letter-spacing:1px;">Order Number</p>
                                    <p style="margin:4px 0 0;font-size:15px;color:#1a1a2e;font-weight:700;">#{{ $order->id }}</p>
                                </td>
                                <td style="padding:16px 20px;border-right:1px solid #e9ecef;" width="33%">
                                    <p style="margin:0;font-size:11px;color:#999999;text-transform:uppercase;letter-spacing:1px;">Order Date</p>
                                    <p style="margin:4px 0 0;font-size:15px;color:#1a1a2e;font-weight:600;">{{ $order->created_at->format('M d, Y') }}</p>
                                </td>
                                <td style="padding:16px 20px;" width="33%">
                                    <p style="margin:0;font-size:11px;color:#999999;text-transform:uppercase;letter-spacing:1px;">Status</p>
                                    <p style="margin:4px 0 0;">
                                        <span style="display:inline-block;background:#fff3cd;color:#856404;font-size:12px;font-weight:600;padding:3px 10px;border-radius:20px;border:1px solid #ffc107;">
                                            {{ ucfirst(strtolower($order->status)) }}
                                        </span>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Items Table --}}
                <tr>
                    <td style="padding:0 40px;">
                        <p style="margin:0 0 12px;font-size:15px;font-weight:700;color:#1a1a2e;">Order Items</p>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                            <thead>
                                <tr style="background-color:#1a1a2e;">
                                    <th style="padding:10px 14px;text-align:left;font-size:12px;color:#a0a0c0;font-weight:600;text-transform:uppercase;letter-spacing:1px;">Product</th>
                                    <th style="padding:10px 14px;text-align:center;font-size:12px;color:#a0a0c0;font-weight:600;text-transform:uppercase;letter-spacing:1px;" width="60">Qty</th>
                                    <th style="padding:10px 14px;text-align:right;font-size:12px;color:#a0a0c0;font-weight:600;text-transform:uppercase;letter-spacing:1px;" width="90">Price</th>
                                    <th style="padding:10px 14px;text-align:right;font-size:12px;color:#a0a0c0;font-weight:600;text-transform:uppercase;letter-spacing:1px;" width="90">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $index => $item)
                                <tr style="background-color:{{ $index % 2 === 0 ? '#ffffff' : '#f8f9fa' }};border-bottom:1px solid #e9ecef;">
                                    <td style="padding:12px 14px;font-size:14px;color:#333333;">
                                        {{ $item->product->name_en ?? 'Product' }}
                                    </td>
                                    <td style="padding:12px 14px;text-align:center;font-size:14px;color:#555555;">{{ $item->quantity }}</td>
                                    <td style="padding:12px 14px;text-align:right;font-size:14px;color:#555555;">{{ number_format($item->unit_price, 2) }}</td>
                                    <td style="padding:12px 14px;text-align:right;font-size:14px;color:#333333;font-weight:600;">{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>

                {{-- Totals --}}
                <tr>
                    <td style="padding:16px 40px 0;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="60%"></td>
                                <td width="40%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:2px solid #e9ecef;">
                                        <tr>
                                            <td style="padding:8px 0;font-size:13px;color:#666666;">Subtotal</td>
                                            <td style="padding:8px 0;font-size:13px;color:#333333;text-align:right;">{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        @if($order->shipping > 0)
                                        <tr>
                                            <td style="padding:4px 0;font-size:13px;color:#666666;">Shipping</td>
                                            <td style="padding:4px 0;font-size:13px;color:#333333;text-align:right;">{{ number_format($order->shipping, 2) }}</td>
                                        </tr>
                                        @endif
                                        @if($order->tax > 0)
                                        <tr>
                                            <td style="padding:4px 0;font-size:13px;color:#666666;">Tax</td>
                                            <td style="padding:4px 0;font-size:13px;color:#333333;text-align:right;">{{ number_format($order->tax, 2) }}</td>
                                        </tr>
                                        @endif
                                        @if($order->discount > 0)
                                        <tr>
                                            <td style="padding:4px 0;font-size:13px;color:#27ae60;">Discount</td>
                                            <td style="padding:4px 0;font-size:13px;color:#27ae60;text-align:right;">- {{ number_format($order->discount, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr style="border-top:2px solid #1a1a2e;">
                                            <td style="padding:10px 0 4px;font-size:16px;color:#1a1a2e;font-weight:700;">Total</td>
                                            <td style="padding:10px 0 4px;font-size:16px;color:#1a1a2e;font-weight:700;text-align:right;">{{ number_format($order->total, 2) }} EGP</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Delivery Address --}}
                @if($order->address)
                <tr>
                    <td style="padding:24px 40px;">
                        <p style="margin:0 0 10px;font-size:15px;font-weight:700;color:#1a1a2e;">Delivery Address</p>
                        <table cellpadding="0" cellspacing="0" border="0" style="background:#f8f9fa;border-radius:6px;border:1px solid #e9ecef;width:100%;">
                            <tr>
                                <td style="padding:16px 20px;">
                                    <p style="margin:0;font-size:14px;color:#333333;font-weight:600;">{{ $order->address->name }}</p>
                                    @if($order->address->details)
                                    <p style="margin:6px 0 0;font-size:14px;color:#555555;">{{ $order->address->details }}</p>
                                    @endif
                                    @if($order->address->notes)
                                    <p style="margin:6px 0 0;font-size:13px;color:#888888;font-style:italic;">Note: {{ $order->address->notes }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endif

                {{-- Footer --}}
                <tr>
                    <td style="background-color:#1a1a2e;padding:24px 40px;text-align:center;margin-top:10px;">
                        <p style="margin:0;font-size:13px;color:#a0a0c0;">
                            Questions? Contact us at
                            <a href="mailto:support@safsafah.com" style="color:#7986cb;text-decoration:none;">support@safsafah.com</a>
                        </p>
                        <p style="margin:10px 0 0;font-size:12px;color:#666688;">
                            &copy; {{ date('Y') }} Safsafah. All rights reserved.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
