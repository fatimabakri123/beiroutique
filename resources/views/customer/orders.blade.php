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
/* BASE */
body {
    background: #f6f7fb;
}

/* PAGE */
.order-page {
    max-width: 1100px;
    margin: 40px auto;
    padding: 30px;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    color: #222;
}

/* FILTERS */
.filters-form {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.filters-form div {
    display: flex;
    flex-direction: column;
}

.filters-form label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #764a0b;
    font-size: 15px;
}

.filters-form select {
    padding: 7px 12px;
    border-radius: 8px;
    border: 1px solid #bbb;
    background: #fff;
    color: #333;
    min-width: 160px;
    font-size:15px;
}

.filters-form button {
    align-self: flex-end;
    padding: 8px 18px;
    background: #8B5E34;
    border: none;
    color: #fff;
    border-radius: 8px;
    cursor: pointer;
}

.filters-form button:hover {
    background: #734A25;
}

/* ORDER CARD */
.order-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 35px;
    box-shadow: 0 10px 30px rgba(0,0,0,.06);
}

/* HEADER */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.order-header h2 {
    margin: 0;
    font-size: 22px;
    color: #8B5E34;
}

.order-date {
    font-size: 14px;
    color: #555;
}

/* STATUS */
.status-badge {
    padding: 7px 18px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 700;
}

.status-delivered {
    background: #DFF5EA;
    color: #0F6B45;
}

.status-pending {
    background: #FFF4CC;
    color: #8A6D00;
}

.status-cancelled {
    background: #FFE3E3;
    color: #8F1D1D;
}

/* TABLE */
.order-table-wrapper {
    overflow-x: auto;
}

.order-table {
    width: 100%;
    min-width: 750px;
    border-collapse: collapse;
}

.order-table thead {
    background: #8B5E34;
}

.order-table th {
    padding: 14px;
    font-weight: 700;
    color: #ffffff;
    font-size: 16px;
    text-align: center;
}

.order-table td {
    padding: 14px;
    font-size: 18px;
    color: #1b0f07e1;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.order-table tbody tr:hover {
    background: #6a3e1256;
}

.product-name {
    font-weight: 600;
    color: #333;
    font-size: 20px;
}

/* IMAGE */
.table-img {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    object-fit: cover;
}

/* PRICE */
.sale-price {
    color: #75242b;
    font-weight: 700;
    font-size: 16px;
}

.old-price {
    text-decoration: line-through;
    color: #180707;
    font-size: 13px;
}

.normal-price {
    color: #1b1b1b;
    font-weight: 600;
    font-size: 15px;
}

/* TOTAL */
.total-cell {
    font-weight: 700;
    color: #8B5E34;
    font-size: 15px;
}

/* REPORT */
.report-btn {
    padding: 6px 14px;
    background: #E5533D;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
}

.report-btn:hover {
    background: #C94430;
}

/* PAGINATION */
.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

/* EMPTY */
.no-orders {
    text-align: center;
    font-size: 18px;
    color: #777;
}

/* MOBILE */
@media(max-width: 768px) {
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .order-table {
        min-width: 650px;
    }
}
</style>
@endsection
