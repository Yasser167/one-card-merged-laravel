<!DOCTYPE html>
<html>

<head>
    <title>Purchase Completed</title>
</head>

<body>
    <div>
        <h1>Purchase Completed Successfully</h1>
        <p><strong>Name:</strong> {{ $data['name'] }}</p>
        <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
        <p><strong>Phone 2:</strong> {{ $data['phone_2'] }}</p>
        <p><strong>Address:</strong> {{ $data['address'] }}</p>

        <h2>Cart Items:</h2>
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <thead>
                <tr>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; background-color: #f4f4f4; font-weight: bold;">Name product</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; background-color: #f4f4f4; font-weight: bold;">Price</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; background-color: #f4f4f4; font-weight: bold;">Quantity</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; background-color: #f4f4f4; font-weight: bold;">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalPrice = 0;
                $totalQuantity = 0;
                @endphp

                @if(is_array($data['cart_items']) && count($data['cart_items']) > 0)
                @foreach ($data['cart_items'] as $item)
                @php
                $itemTotal = $item['price'] * $item['quantity'];
                $totalPrice += $itemTotal;
                $totalQuantity += $item['quantity'];
                @endphp
                <tr style="background-color: {{ $loop->even ? '#f9f9f9' : 'white' }};">
                    <td style="padding: 12px; text-align: left; border: 1px solid #ddd;">{{ $item['name'] }}</td>
                    <td style="padding: 12px; text-align: left; border: 1px solid #ddd;">{{ number_format($item['price'], 2) }}</td>
                    <td style="padding: 12px; text-align: left; border: 1px solid #ddd;">{{ $item['quantity'] }}</td>
                    <td style="padding: 12px; text-align: left; border: 1px solid #ddd;">{{ number_format($itemTotal, 2) }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" style="text-align: center; font-size: 18px; color: #777; padding: 20px;">No items in cart.</td>
                </tr>
                @endif
            </tbody>
        </table>

        <h4>Total Quantity: {{ $totalQuantity }}</h4>
        <h4>Total Price: {{ number_format($totalPrice, 2) }}</h4>
    </div>

</body>

</html>
