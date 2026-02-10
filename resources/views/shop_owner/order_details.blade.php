<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
:root {
   --purple-dark: #5b2a86;
   --purple-soft: #1f7bb8eb;
   --blue-soft: #8f3f9beb;

   --bg-light: #fdfcff;
   --white: #ffffff;

   --text-dark: #1e1b4b;
   --text-muted: #6b7280;

   --border-soft: rgba(226,232,240,0.8);
   --shadow-soft: 0 18px 40px rgba(91, 42, 134, 0.18);
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--bg-light);
    color: var(--text-dark);
    margin: 0;
    padding: 0;
}

.dashboard-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
}

.table-container {
    background: var(--white);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: var(--shadow-soft);
}

.table-container h3 {
    margin-bottom: 15px;
    color: var(--purple-dark);
    font-size: 20px;
    border-left: 4px solid var(--purple-dark);
    padding-left: 10px;
}

.table-container p {
    margin: 8px 0;
    font-size: 18px;
}

.table-container p strong {
    color: var(--purple-dark);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table th, table td {
    padding: 12px;
    border-bottom: 1px solid var(--border-soft);
    font-size: 18px;
}

table th {
    background-color: var(--purple-dark);
    color: var(--white);
    text-align: left;
    border-radius: 4px;
}

.status-select {
    padding: 8px 14px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    color: #fff;
    min-width: 140px;
    text-transform: capitalize;
    font-size: 16px;
}

.status-select.pending { background-color: var(--purple-dark); }
.status-select.processing { background-color: var(--purple-soft); }
.status-select.shipped { background-color: var(--blue-soft); }
.status-select.delivered { background-color: #A67C52; }
.status-select.cancelled { background-color: #452dcd; }

.add-btn {
    display: inline-block;
    padding: 12px 22px;
    background-color: var(--purple-dark);
    color: var(--white);
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    font-size: 16px;
}

.add-btn:hover {
    background-color: var(--purple-soft);
}
</style>

<div class="order-details-page">
    <div class="dashboard-container">

        <h2>Order #{{ $order->order_id }}</h2>

        {{-- Customer Info --}}
        <div class="table-container">
            <h3>Customer Info</h3>
            <p><strong>Name:</strong> {{ $order->full_name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            @php use Illuminate\Support\Str; @endphp

           <p><strong>Address:</strong></p>

@php
    $lines = explode("\n", $order->shipping_address);
    $lat = null;
    $lng = null;
@endphp

@foreach($lines as $line)
    @if(Str::startsWith(trim($line), 'Location:'))
        @php
            $coords = str_replace('Location:', '', $line);
            [$lat, $lng] = array_map('trim', explode(',', $coords));
        @endphp
    @else
        <p>{{ $line }}</p>
    @endif
@endforeach

@if($lat && $lng)
    <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}"
       target="_blank"
       style="color:#C08A56; font-weight:600;">
        📍 Open Location on Google Maps
    </a>
@endif

            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->paymentMethod->method_name) }}</p>
            <p><strong>Delivery Method:</strong> {{ ucfirst($order->deliveryMethod->method_name) }}</p>
        </div>

        {{-- Order Status --}}
        <div class="table-container">
            <h3>Order Status</h3>

            <form action="{{ route('shop.orders.updateStatus', $order->order_id) }}" method="POST">
                @csrf
                @method('PUT')

                <select name="order_status"
                        id="statusSelect"
                        class="status-select {{ $order->order_status }}">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                        <option value="{{ $status }}"
                            {{ $order->order_status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="add-btn">Update Status</button>
            </form>
        </div>

        {{-- Products --}}
        <div class="table-container">
            <h3>Products Bought From Your Shop</h3>

            <table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Color</th>
            <th>Size</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->color ?? '-' }}</td>
                <td>{{ $item->size ?? '-' }}</td>
                <td>${{ $item->price_at_purchase }}</td>
                <td>${{ $item->quantity * $item->price_at_purchase }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


            <h3 style="text-align:right;margin-top:20px;">
                Total: ${{ number_format($total, 2) }}
            </h3>
        </div>

        {{-- Back Button --}}
        <div class="back-btn-wrapper">
           <a href="{{ route('shop.dashboard') }}" class="add-btn">⬅ Back</a>

        </div>

    </div>
</div>

{{-- JS for live status color update --}}
<script>
    const statusSelect = document.getElementById('statusSelect');

    function updateStatusClass() {
        statusSelect.className = 'status-select ' + statusSelect.value;
    }

    statusSelect.addEventListener('change', updateStatusClass);
    updateStatusClass();
</script>
</body>
</html>