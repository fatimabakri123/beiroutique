@extends('admin.layout')
@section('title','Order')

@section('content')

<style>
:root {
    --primary: #7b2fae;
    --bg: #f4f6fa;
    --card: #fff;
    --text: #2c3e50;
    --muted: #7f8c8d;
    --shadow: 0 6px 18px rgba(124,77,255,0.08);
    --shadow-hover: 0 10px 25px rgba(124,77,255,0.15);
}

/* ===== WRAPPER ===== */
.order-wrapper {
    max-width: 900px;
    margin: 30px auto;
    padding: 0 15px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* ===== ORDER CARD ===== */
.order-card {
    background: var(--card);
    border-radius: 16px;
    padding: 20px 25px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.order-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

/* ===== HEADER ===== */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.order-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: var(--primary);
}

.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: capitalize;
    color: #fff;
    min-width: 80px;
    text-align: center;
    transition: all 0.3s ease;
}

.badge.pending { background: #f6c23e; }
.badge.processing { background: #36b9cc; }
.badge.delivered { background: #1cc88a; }
.badge.cancelled { background: #e74a3b; }
.badge.shipped { background: #4e73df; }

/* ===== ORDER INFO ===== */
.order-info {
    display: flex;
    flex-wrap: wrap;
    gap: 12px 20px;
    margin-bottom: 10px;
}

.order-info p {
    margin: 0;
    font-size: 18px;
    color: var(--text);
}

.order-info span {
    color: var(--muted);
    font-weight: 500;
}

/* ===== ITEMS GRID ===== */
.items-grid {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
}

.item-card {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: var(--bg);
    border-radius: 12px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.item-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.item-card img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}

.item-card h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--primary);
}

.item-card p {
    margin: 0;
    font-size: 16px;
    color: var(--muted);
}

.item-card .price {
    font-weight: 600;
    color: var(--primary);
}

/* ===== TOTAL ===== */
.order-total {
    margin-top: 15px;
    padding: 12px;
    background: linear-gradient(135deg, #7b2fae, #a64dd1);
    color: #fff;
    border-radius: 16px;
    font-size: 16px;
    font-weight: 700;
    text-align: center;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}

.order-total:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-hover);
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .item-card { flex-direction: column; align-items: flex-start; }
    .item-card img { width: 100%; height: 120px; }
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
        @php
            $images = collect();

            if ($it->product->images && $it->product->images->count()) {
                $images = $it->product->images;
            } elseif (!empty($it->product->image_url)) {
                $images = collect([(object)['image_path' => $it->product->image_url]]);
            }
        @endphp

        <div class="item-card">
            <div class="item-image">
                @if($images->count())
                    <img
                        src="{{ Str::startsWith($images->first()->image_path,'products/')
                                ? asset('storage/'.$images->first()->image_path)
                                : asset($images->first()->image_path) }}"
                        alt="{{ $it->product->product_name }}">
                @else
                    <img src="{{ asset('images/no-image.png') }}" alt="No image">
                @endif
            </div>

            <div class="item-details">
                <h5>{{ $it->product->product_name }}</h5>
                <p>Shop: {{ $it->product->shop->shop_name }}</p>
                <p>Quantity: {{ $it->quantity }}</p>
                <p>Unit Price: ${{ $it->price_at_purchase }}</p>
                <div class="price">
                    Subtotal: ${{ $it->quantity * $it->price_at_purchase }}
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
.item-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px 12px;
    background: var(--bg);
    border-radius: 12px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}
.item-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.item-card .item-image img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}

.item-card .item-details h5 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--primary);
}
.item-card .item-details p {
    margin: 2px 0;
    font-size: 14px;
    color: var(--muted);
}
.item-card .item-details .price {
    font-weight: 600;
    color: var(--primary);
}

@media(max-width:768px){
    .item-card { flex-direction: column; align-items: flex-start; }
    .item-card .item-image img { width: 100%; height: 120px; }
}
</style>


</div>

@endsection
