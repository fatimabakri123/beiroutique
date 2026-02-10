@extends('layouts.customer')

@section('content')
<div class="order-page">
    <div class="back-btn-wrapper">
        <style>
            .back-btn-wrapper { margin-bottom: 25px; }
            .back-btn {
                display: inline-flex;
                align-items: center;
                padding: 10px 18px;
                background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
                color: #fff;
                font-weight: 600;
                font-size:20px;
                border-radius: 12px;
                text-decoration: none;
                box-shadow: 0 8px 25px rgba(124,77,255,0.25);
                transition: all 0.3s ease;
            }
            .back-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 30px rgba(96,165,250,0.35);
                color: #fff;
            }
        </style>
    </div>

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
            $deliveryCost = $order->deliveryMethod->cost ?? 0;
            $itemCount = $order->items->count() ?: 1; // prevent division by zero
        @endphp

        <div class="order-card">
            {{-- Header --}}
            <div class="order-header">
                <div>
                    <h2>{{ $order->items->first()?->product->shop->shop_name ?? 'N/A' }}</h2>
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
                <table class="order-table vertical">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Qty</th>
                            <th>Price + Delivery</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            @php
                                $originalPrice = $item->product->price ?? 0;
                                $finalPrice = ($item->product->is_on_sale ?? false)
                                    ? $item->product->discount_value
                                    : $originalPrice;

                                // Safely share delivery per item
                                $deliveryShare = $deliveryCost > 0 ? $deliveryCost / $itemCount : 0;
                                $totalPerItem = ($finalPrice + $deliveryShare) * $item->quantity;

                                // Product image
                                $productImage = null;
                                if ($item->product) {
                                    if ($item->product->images()->exists()) {
                                        $productImage = $item->product->images()->first()->image_path;
                                    } else {
                                        $productImage = $item->product->image_url;
                                    }
                                }
                            @endphp

                            <tr>
                                <td data-label="Product">{{ $item->product?->product_name ?? 'Product Deleted' }}</td>

                                <td data-label="Image">
                                    @if($productImage)
                                        <img class="table-img" 
                                             src="{{ Str::startsWith($productImage, 'products/') ? asset('storage/'.$productImage) : asset($productImage) }}">
                                    @endif
                                </td>

                                <td data-label="Qty">{{ $item->quantity }}</td>

                                <td data-label="Price + Delivery">
                                    ${{ number_format($finalPrice + $deliveryShare, 2) }}
                                </td>

                                <td data-label="Total" class="total-cell">
                                    ${{ number_format($totalPerItem, 2) }}
                                </td>

                                <td data-label="Action">
                                    @if($order->order_status === 'Delivered' && $item->product)
                                        <a href="{{ route('reports.create', [$order->order_id, $item->product->product_id]) }}"
                                           class="report-btn">Add Report</a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        {{-- Grand Total --}}
                        @php
                            $itemsTotal = $order->items->sum(function($i) {
                                $price = ($i->product->is_on_sale ?? false)
                                    ? $i->product->discount_value
                                    : ($i->product->price ?? 0);
                                return $price * $i->quantity;
                            });
                            $grandTotal = $itemsTotal + $deliveryCost;
                        @endphp

                        <tr>
                            <td colspan="4" style="text-align:right; font-weight:bold;">Delivery Cost:</td>
                            <td colspan="2" style="font-weight:bold;">${{ number_format($deliveryCost,2) }}</td>
                        </tr>

                        <tr>
                            <td colspan="4" style="text-align:right; font-weight:bold;">Grand Total:</td>
                            <td colspan="2" style="font-weight:bold; color:#8f3f9b;">${{ number_format($grandTotal,2) }}</td>
                        </tr>

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
    html, body { max-width: 100%; overflow-x: hidden; }
    .order-page { width: 100%; max-width: 100%; margin: 0 auto; font-family: 'Poppins', sans-serif; color: var(--text-dark); padding: 30px 40px; min-height: 100vh; background: linear-gradient(135deg, #fdfcff, #f6f0ff); border-radius: 24px; box-shadow: inset 0 0 0 1px rgba(124,77,255,0.08); }
    .filters-form { display: flex; gap: 20px; background: linear-gradient(135deg, #ffffff, #faf5ff); padding: 28px; border-radius: 20px; box-shadow: 0 18px 40px rgba(124,77,255,0.15); margin-bottom: 45px; border: 1px solid rgba(124,77,255,0.1); }
    .filters-form div { flex:1; display:flex; flex-direction: column; }
    .filters-form label { font-size: 13px; font-weight: 600; color: var(--purple-dark); margin-bottom: 6px; }
    .filters-form select { padding: 12px; border-radius: 10px; border: 1px solid #ddd; font-size: 14px; }
    .filters-form select:focus { outline:none; border-color: var(--purple-dark); }
    .filters-form button { background: linear-gradient(135deg, #7b2fae, #8f3f9b); color: #fff; border: none; padding: 12px 32px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .filters-form button:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(124,77,255,0.25); }
    .order-card { background: var(--white); border-radius: 22px; padding: 30px; margin-bottom: 40px; box-shadow: 0 20px 45px rgba(124,77,255,0.15); border: 1px solid rgba(124,77,255,0.08); }
    .order-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; padding-bottom: 18px; margin-bottom: 22px; }
    .order-header h2 { margin:0; font-size:20px; font-weight:700; color:#7b2fae; }
    .order-date { font-size:15px; color:#6b7280; }
    .status-badge { padding: 8px 18px; border-radius:999px; font-size:16px; font-weight:700; text-transform: uppercase; }
    .status-delivered { background:#f1eaff; color:#7b2fae; }
    .status-pending { background:#fcefff; color:#a35fd1; }
    .status-cancelled { background:#fee2e2; color:#dc2626; }
    .order-table { width:100%; border-collapse: separate; border-spacing:0 12px; }
    .order-table th { font-size:16px; color:#6b7280; text-transform:uppercase; padding:8px 14px; }
    .order-table td { background: #ffffff; padding: 16px; border-top: 1px solid #eee; border-bottom: 1px solid #eee; text-align: center; vertical-align: middle; }
    .order-table tr td:first-child { border-radius:12px 0 0 12px; }
    .order-table tr td:last-child { border-radius:0 12px 12px 0; }
    .table-img { width:60px; height:60px; border-radius:12px; object-fit:cover; box-shadow:0 6px 14px rgba(0,0,0,0.1); }
    .total-cell { font-weight:800; font-size:16px; color:#8f3f9b; }
    .report-btn { padding:8px 16px; border-radius:10px; font-size:12px; font-weight:600; border:1px solid #7b2fae; color:#7b2fae; text-decoration:none; transition: all 0.25s ease; }
    .report-btn:hover { background:#7b2fae; color:#fff; }
    .pagination-wrapper { margin-top:40px; display:flex; justify-content:center; }
    @media (max-width: 768px) { .filters-form { flex-direction: column; } .order-header { flex-direction: column; align-items:flex-start; gap:10px; } }
    .order-table-wrapper { width: 100%; overflow-x: auto; display:flex; flex-direction: column; gap:18px; }
</style>
@endsection