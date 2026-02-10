@extends('admin.layout')
@section('title','Orders')
@section('content')

<style>
/* ===== Filters Styling ===== */
.filters-card {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
    align-items: flex-end;
}

.filter-select {
    padding: 6px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background: #fff;
    font-weight: 600;
    color: #5e1cc0;
    transition: all 0.3s ease;
    min-width: 150px;
}

.filter-select:focus {
    outline: none;
    border-color: #5e1cc0;
    box-shadow: 0 0 8px rgba(94,28,192,0.3);
}

.btn-filter {
    background: linear-gradient(90deg, #5e1cc0, #8f3fff);
    color: #fff;
    font-weight: 600;
    padding: 6px 18px;
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    background: linear-gradient(90deg, #350799, #5e1cc0);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(124,77,255,0.25);
}

.btn-filter:active {
    transform: translateY(0);
    box-shadow: none;
}

/* ===== Table Styling ===== */
.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}

.table-custom thead th {
    background: #f5f2ff;
    color: #5e1cc0;
    font-weight: 700;
    text-align: center;
    padding: 12px;
    border-radius: 12px;
}

.table-custom tbody tr {
    background: #fff;
    box-shadow: 0 6px 18px rgba(124,77,255,0.08);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.table-custom tbody tr:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(124,77,255,0.18);
}

.table-custom td {
    text-align: center;
    vertical-align: middle;
    padding: 12px;
    border: none;
}

/* Status Colors */
.status-pending {
    background-color: #fff3cd !important;
    color: #856404 !important;
    font-weight: bold;
    border-radius: 12px;
    padding: 4px 10px;
}

.status-delivered {
    background-color: #d4edda !important;
    color: #155724 !important;
    font-weight: bold;
    border-radius: 12px;
    padding: 4px 10px;
}

.status-processing {
    background-color: #cce5ff !important;
    color: #004085 !important;
    font-weight: bold;
    border-radius: 12px;
    padding: 4px 10px;
}

.status-cancelled {
    background-color: #f8d7da !important;
    color: #721c24 !important;
    font-weight: bold;
    border-radius: 12px;
    padding: 4px 10px;
}

/* Pagination Next/Previous */
.pagination-custom {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}
</style>

<h3 class="text-center mb-3" style="color:#5e1cc0;">Orders</h3>

{{-- Filters --}}
<form method="GET" class="filters-card">
    <div>
        <label for="shopFilter">Filter by Shop:</label>
        <select name="shop_id" id="shopFilter" class="filter-select">
            <option value="">All Shops</option>
            @foreach(\App\Models\Shop::all() as $shop)
                <option value="{{ $shop->shop_id }}" {{ request('shop_id') == $shop->shop_id ? 'selected' : '' }}>
                    {{ $shop->shop_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="statusFilter">Filter by Status:</label>
        <select name="status" id="statusFilter" class="filter-select">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    <button type="submit" class="btn-filter mt-2">Filter</button>
</form>

{{-- Orders Table --}}
<table class="table-custom">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Shop</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $o)
        <tr>
            <td>#{{ $o->order_id }}</td>
            <td>{{ $o->customer->user->name }} {{ $o->customer->user->last_name }}</td>
            <td>${{ number_format($o->total_amount, 2) }}</td>
            <td class="status-{{ $o->order_status }}">{{ ucfirst($o->order_status) }}</td>
            <td>
                @php
                    $shops = $o->items->map(fn($i)=>$i->product->shop->shop_name ?? null)->unique();
                @endphp
                {{ $shops->implode(', ') ?: 'N/A' }}
            </td>
            <td>{{ $o->order_date }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $o->order_id) }}" class="btn btn-outline-primary btn-sm">Details</a>
            </td>
        </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted">No orders found.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination Next / Previous Only --}}
<div class="pagination-custom">
    @if($orders->onFirstPage())
        <span class="btn btn-secondary btn-sm disabled">Previous</span>
    @else
        <a href="{{ $orders->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
    @endif

    @if($orders->hasMorePages())
        <a href="{{ $orders->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
    @else
        <span class="btn btn-secondary btn-sm disabled">Next</span>
    @endif
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#sidebar-links .nav-link').removeClass('active');
    $('#sidebar-orders-link').addClass('active');
});
</script>
