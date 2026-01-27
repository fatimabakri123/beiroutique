@extends('admin.layout')
@section('title','Order')

@section('content')

<style>
:root {
    --primary: #4e73df;
    --bg: #f8f9fc;
    --card: #ffffff;
    --text: #2e2f33;
    --muted: #858796;
    --success: #1cc88a;
    --shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.order-wrapper {
    max-width: 900px;
    margin: auto;
}

.order-card {
    background: var(--card);
    border-radius: 16px;
    padding: 25px;
    box-shadow: var(--shadow);
    margin-bottom: 30px;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.order-header h3 {
    margin: 0;
    color: var(--primary);
    font-size:25px;
   
}

.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    background: var(--primary);
    color: #fff;
}

.order-info p {
    margin: 6px 0;
    color: var(--text);
    font-size:20px
}

.order-info span {
    color: var(--muted);
    font-weight: 500;
}

/* ===== ITEMS ===== */
.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.item-card {
    background: var(--bg);
    border-radius: 14px;
    padding: 15px;
    box-shadow: var(--shadow);
    transition: 0.3s;
}

.item-card:hover {
    transform: translateY(-4px);
}

.item-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

.item-card h5 {
    margin: 6px 0;
    font-size: 20px;
    color: var(--text);
}

.item-card p {
    margin: 4px 0;
    font-size: 18px;
    color: var(--muted);
}

.item-card .price {
    margin-top: 8px;
    font-weight: 700;
    color: var(--primary);
}

/* ===== TOTAL ===== */
.order-total {
    margin-top: 25px;
    padding: 15px;
    background: linear-gradient(135deg, var(--primary), #6f86ff);
    color: #fff;
    border-radius: 14px;
    font-size: 18px;
    font-weight: 700;
    text-align: center;
}
/* ===== STATUS COLORS ===== */
.badge.pending {
    background: #f6c23e; /* yellow */
    color: #fff;
}

.badge.processing {
    background: #36b9cc; /* cyan */
    color: #fff;
}

.badge.delivered {
    background: #36a079; /* green */
    color: #fff;
}

.badge.cancelled {
    background: #e74a3b; /* red */
    color: #fff;
}

.badge.shipped {
    background: #4e73df; /* blue */
    color: #fff;
}

</style>

<div class="order-wrapper">

    <!-- ORDER SUMMARY -->
    <div class="order-card">
        <div class="order-header">
            <h3>Order #{{ $order->order_id }}</h3>
           <span class="badge {{ strtolower($order->order_status) }}">
    {{ ucfirst($order->order_status) }}
</span>

        </div>

        <div class="order-info">
            <p><strong>Customer:</strong>
                <span>{{ $order->customer->user->name }} {{ $order->customer->user->last_name }}</span>
            </p>
            <p><strong>Total Amount:</strong>
                <span>${{ number_format($order->total_amount, 2) }}</span>
            </p>
        </div>
    </div>

    <!-- ORDER ITEMS -->
    <div class="order-card">
        <h4>Order Items</h4>

        <div class="items-grid">
            @foreach($order->items as $it)
                <div class="item-card">
                    <img src="{{ asset('storage/' . $it->product->image_url) }}"
                         alt="{{ $it->product->product_name }}">

                    <h5>{{ $it->product->product_name }}</h5>

                    <p>Shop: {{ $it->product->shop->shop_name }}</p>
                    <p>Quantity: {{ $it->quantity }}</p>
                    <p>Unit Price: ${{ $it->price_at_purchase }}</p>

                    <div class="price">
                        Subtotal: ${{ $it->quantity * $it->price_at_purchase }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="order-total">
            Total Order: ${{ number_format($order->total_amount, 2) }}
        </div>
    </div>

</div>

@endsection
