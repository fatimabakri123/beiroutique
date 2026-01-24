@extends('admin.layout')
@section('title','Orders')
@section('content')

<style>
/* Full cell background colors for statuses */
.status-pending {
    background-color: #fff3cd !important;
    color: #856404 !important;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
    padding: 5px 10px;
}
.status-delivered {
    background-color: #d4edda !important;
    color: #155724 !important;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
    padding: 5px 10px;
}
.status-processing {
    background-color: #cce5ff !important;
    color: #004085 !important;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
    padding: 5px 10px;
}
.status-cancelled {
    background-color: #f8d7da !important;
    color: #721c24 !important;
    font-weight: bold;
    text-align: center;
    border-radius: 5px;
    padding: 5px 10px;
}
</style>

<h5>Orders</h5>
<div class="card p-2">

    {{-- Filters --}}
    <form method="GET" class="mb-3 d-flex align-items-center flex-wrap">
        {{-- Shop Filter --}}
        <label for="shopFilter">Filter by Shop:</label>
        <select name="shop_id" id="shopFilter" class="form-select w-auto d-inline-block ms-2">
            <option value="">All Shops</option>
            @foreach(\App\Models\Shop::all() as $shop)
                <option value="{{ $shop->shop_id }}" {{ request('shop_id') == $shop->shop_id ? 'selected' : '' }}>
                    {{ $shop->shop_name }}
                </option>
            @endforeach
        </select>

        {{-- Status Filter --}}
        <label for="statusFilter" class="ms-3">Filter by Status:</label>
        <select name="status" id="statusFilter" class="form-select w-auto d-inline-block ms-2">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit" class="btn btn-primary btn-sm ms-3 mt-2 mt-sm-0">Filter</button>
    </form>

    {{-- Orders Table --}}
    <table class="table table-bordered align-middle">
        <thead class="table-light">
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
            @foreach($orders as $o)
            <tr>
                <td>#{{ $o->order_id }}</td>
                <td>{{ $o->customer->user->name }} {{ $o->customer->user->last_name }}</td>
                <td>${{ number_format($o->total_amount, 2) }}</td>

                {{-- Status full cell --}}
                <td class="status-{{ $o->order_status }}">
                    {{ ucfirst($o->order_status) }}
                </td>

                {{-- Shops --}}
                <td>
                    @php
                        $shops = $o->items->map(fn($item) => $item->product->shop->shop_name ?? null)->unique();
                    @endphp
                    {{ $shops->implode(', ') ?: 'N/A' }}
                </td>

                <td>{{ $o->order_date }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $o->order_id) }}" class="btn btn-sm btn-outline-primary">Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <ul class="pagination justify-content-center">
        @if ($orders->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $orders->previousPageUrl() }}">«</a>
            </li>
        @endif

        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
            <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        @if ($orders->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $orders->nextPageUrl() }}">»</a>
            </li>
        @else
            <li class="page-item disabled"><span class="page-link">»</span></li>
        @endif
    </ul>

</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Highlight the active sidebar link
        $('#sidebar-links .nav-link').removeClass('active');
        $('#sidebar-orders-link').addClass('active');
    });
</script>