@extends('layouts.customer')

@section('content')
<div class="order-page">

    {{-- ================= FILTERS ================= --}}
    <form method="GET" class="filters-form">
        <div>
            <label>Filter by Shop</label>
            <select name="shop_id">
                <option value="all">All Shops</option>
                @foreach($shops as $shop)
                    <option value="{{ $shop->shop_id }}" {{ request('shop_id') == $shop->shop_id ? 'selected' : '' }}>
                        {{ $shop->shop_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Filter by Status</label>
            <select name="status">
                <option value="all">All Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Apply</button>
    </form>

    {{-- ================= ORDERS ================= --}}
    @forelse($orders as $order)

        @php
            $firstItem = $order->items->first();
            $shopName = $firstItem && $firstItem->product && $firstItem->product->shop
                ? $firstItem->product->shop->shop_name
                : 'N/A';
        @endphp

        <div class="order-card">

            {{-- Header --}}
            <div class="order-header">
                <div>
                    <h2>{{ $shopName }}</h2>
                    <span class="order-date">
                        Order #{{ $order->order_id }} • {{ $order->created_at->format('d M Y') }}
                    </span>
                </div>

                <span class="status-badge status-{{ strtolower($order->order_status) }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>

            {{-- Table --}}
            <div class="order-table-wrapper">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="product-name">
                                {{ $item->product?->product_name ?? 'Product Deleted' }}
                            </td>

                            <td>
                                @if($item->product?->image_url)
                                    <img class="table-img"
                                         src="{{ Str::startsWith($item->product->image_url, 'products/')
                                            ? asset('storage/' . $item->product->image_url)
                                            : asset($item->product->image_url) }}">
                                @endif
                            </td>

                            <td>{{ $item->quantity }}</td>

                            {{-- PRICE --}}
                            <td>
                                @php
                                    $originalPrice = $item->product->price;
                                    $finalPrice = $item->product->is_on_sale
                                        ? $item->product->discount_value
                                        : $originalPrice;
                                @endphp

                                @if($item->product->is_on_sale)
                                    <span class="sale-price">
                                        ${{ number_format($finalPrice, 2) }}
                                    </span>
                                    <br>
                                    <small class="old-price">
                                        ${{ number_format($originalPrice, 2) }}
                                    </small>
                                @else
                                    <span class="normal-price">
                                        ${{ number_format($originalPrice, 2) }}
                                    </span>
                                @endif
                            </td>

                            {{-- TOTAL --}}
                            <td class="total-cell">
                                ${{ number_format($finalPrice * $item->quantity, 2) }}
                            </td>

                            {{-- ACTION --}}
                            <td>
                                @if($order->order_status === 'Delivered' && $item->product)
                                    <a href="{{ route('reports.create', [$order->order_id, $item->product->product_id]) }}"
                                       class="report-btn">
                                        Add Report
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    @empty
        <p class="no-orders">No orders found.</p>
    @endforelse

    {{-- Pagination --}}
    <div class="pagination-wrapper">
        {{ $orders->links('pagination::simple-bootstrap-5') }}
    </div>

</div>

{{-- ================= STYLES ================= --}}
<style>
/* --- BASE SETUP --- */
:root {
    --primary-color: #b68566; /* Elegant Bronze */
    --text-dark: #2c3e50;
    --text-muted: #f1e9e5;
    --bg-light: #74421c;
    --white: #ffffff;
    --shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

body {
    background-color: var(--bg-light);
    color: var(--text-dark);
}

.order-page {
    max-width: 1200px;
    margin: 50px auto;
    padding: 0 20px;
    font-family: 'Inter', -apple-system, sans-serif;
}

/* --- FILTERS SECTION --- */
.filters-form {
    display: flex;
    align-items: flex-end;
    gap: 20px;
    background: var(--white);
    padding: 25px;
    border-radius: 15px;
    box-shadow: var(--shadow);
    margin-bottom: 40px;
}

.filters-form div {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.filters-form label {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color:  #9a6f52;
    margin-bottom: 8px;
}

.filters-form select {
    padding: 12px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    font-size: 14px;
    background: #fff;
    transition: border 0.3s;
}

.filters-form select:focus {
    border-color: var(--primary-color);
    outline: none;
}

.filters-form button {
    background: var(--primary-color);
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, background 0.2s;
}

.filters-form button:hover {
    background: #9a6f52;
    transform: translateY(-2px);
}

/* --- ORDER CARDS --- */
.order-card {
    background: var(--white);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0,0,0,0.02);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 25px;
}

.order-header h2 {
    font-size: 1.4rem;
    margin: 0;
    color: var(--text-dark);
}

.order-date {
    display: block;
    font-size: 0.9rem;
    color: #9a6f52 ;
    margin-top: 5px;
}

/* --- STATUS BADGES --- */
.status-badge {
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-delivered { background: #e6f9ed; color: #1db459; }
.status-pending { background: #fff8e6; color: #f1c40f; }
.status-cancelled { background: #ffebee; color: #e74c3c; }

/* --- TABLE STYLING --- */
.order-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}

.order-table th {
    text-align: left;
    padding: 10px 15px;
    color: var(--text-muted);
    font-size: 0.8rem;
    text-transform: uppercase;
}

.order-table td {
    padding: 15px;
    background: #fdfdfd;
    vertical-align: middle;
}

.order-table tr td:first-child { border-radius: 10px 0 0 10px; }
.order-table tr td:last-child { border-radius: 0 10px 10px 0; }

.product-name {
    font-weight: 600;
    max-width: 250px;
}

.table-img {
    width: 65px;
    height: 65px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

/* --- PRICING --- */
.sale-price {
    font-weight: 700;
    color: var(--text-dark);
}

.old-price {
    text-decoration: line-through;
    color: #bdc3c7;
    font-size: 0.8rem;
}

.total-cell {
    font-weight: 800;
    color: var(--primary-color);
    font-size: 1.1rem;
}

/* --- ACTIONS --- */
.report-btn {
    background: transparent;
    color: #e74c3c;
    border: 1px solid #e74c3c;
    padding: 6px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s;
}

.report-btn:hover {
    background: #e74c3c;
    color: #fff;
}

/* --- PAGINATION --- */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

/* --- MOBILE RESPONSIVE --- */
@media (max-width: 768px) {
    .filters-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .order-header {
        flex-direction: column;
        gap: 15px;
    }
}
</style>
@endsection
