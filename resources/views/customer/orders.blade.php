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
        $itemCount = $order->items->count() ?: 1;
        $loyaltyDiscount = $order->loyalty_discount_amount ?? 0;
        $loyaltyDiscountPercentage = $order->loyalty_discount ?? 0;
    @endphp

    <div class="order-card">
        {{-- Header with loyalty badge --}}
        <div class="order-header">
            <div>
                <h2>{{ $order->items->first()?->product->shop->shop_name ?? 'N/A' }}</h2>
                <span class="order-date">
                    Order #{{ $order->order_id }} • {{ $order->created_at->format('d M Y') }}
                </span>
                
                {{-- LOYALTY DISPLAY HERE --}}
                @if($loyaltyDiscount > 0)
                    <div class="loyalty-badge">
                        🎉 {{ $loyaltyDiscountPercentage }}% Off
                    </div>
                @endif
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
                        <th>Sale</th>
                        <th>Loyalty</th>
                        <th>Delivery</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        @php
                            // Get product prices
                            $originalPrice = $item->product->price ?? 0;
                            $isOnSale = $item->product->is_on_sale ?? false;
                            $salePrice = $isOnSale ? ($item->product->discount_value ?? 0) : $originalPrice;
                            
                            // Get product image
                            $productImage = null;
                            if ($item->product) {
                                if ($item->product->images && $item->product->images->count() > 0) {
                                    $productImage = $item->product->images->first()->image_path;
                                } else {
                                    $productImage = $item->product->image_url;
                                }
                            }
                            
                            // Loyalty discount
                            $loyaltyDiscountPerUnit = 0;
                            if ($loyaltyDiscountPercentage > 0) {
                                $loyaltyDiscountPerUnit = ($salePrice * $loyaltyDiscountPercentage / 100);
                            }
                            
                            // Price after loyalty
                            $priceAfterLoyalty = $salePrice - $loyaltyDiscountPerUnit;
                            
                            // Delivery share
                            $deliveryShare = $deliveryCost > 0 ? $deliveryCost / $itemCount : 0;
                            $deliverySharePerItem = $deliveryShare * $item->quantity;
                            
                            // Final total for this item
                            $totalPerItem = ($priceAfterLoyalty + $deliveryShare) * $item->quantity;
                            
                            // Sale discount amount
                            $saleDiscountPerUnit = $isOnSale ? ($originalPrice - $salePrice) : 0;
                        @endphp

                        <tr>
                            <td data-label="Product">{{ Str::limit($item->product?->product_name ?? 'Deleted', 20) }}</td>
                            <td data-label="Image">
                                @if($productImage)
                                    <img class="table-img" 
                                         src="{{ Str::startsWith($productImage, 'products/') ? asset('storage/'.$productImage) : asset($productImage) }}">
                                @endif
                            </td>
                            <td data-label="Qty">{{ $item->quantity }}</td>
                            
                            <td data-label="Price">
                                ${{ number_format($originalPrice, 2) }}
                            </td>
                            
                            <td data-label="Sale" class="{{ $saleDiscountPerUnit > 0 ? 'text-success' : 'text-muted' }}">
                                @if($saleDiscountPerUnit > 0)
                                    -${{ number_format($saleDiscountPerUnit, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                            
                            <td data-label="Loyalty" class="{{ $loyaltyDiscountPerUnit > 0 ? 'text-success' : 'text-muted' }}">
                                @if($loyaltyDiscountPerUnit > 0)
                                    -${{ number_format($loyaltyDiscountPerUnit, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                            
                            <td data-label="Delivery" class="text-delivery">
                                +${{ number_format($deliverySharePerItem, 2) }}
                            </td>
                            
                            <td data-label="Total" class="total-cell">
                                ${{ number_format($totalPerItem, 2) }}
                            </td>
                            
                            <td data-label="Action">
                               @if(strtolower(trim($order->order_status)) == 'delivered' && $item->product)
                                    <a href="{{ route('reports.create', [$order->order_id, $item->product->product_id]) }}"
                                       class="report-btn">Report</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    {{-- COMPACT SUMMARY ROW --}}
                    @php
                        $originalTotal = $order->items->sum(function($i) {
                            return ($i->product->price ?? 0) * $i->quantity;
                        });
                        $saleDiscountTotal = $order->sale_discount_amount ?? 0;
                        $loyaltyDiscountTotal = $order->loyalty_discount_amount ?? 0;
                        $finalTotal = $order->total_amount ?? ($originalTotal - $saleDiscountTotal - $loyaltyDiscountTotal + $deliveryCost);
                    @endphp

                    <tr class="summary-row">
                        <td colspan="3" style="text-align: right;"><strong>TOTAL:</strong></td>
                        <td><strong>${{ number_format($originalTotal, 2) }}</strong></td>
                        <td><strong class="text-success">-${{ number_format($saleDiscountTotal, 2) }}</strong></td>
                        <td><strong class="text-success">-${{ number_format($loyaltyDiscountTotal, 2) }}</strong></td>
                        <td><strong class="text-delivery">+${{ number_format($deliveryCost, 2) }}</strong></td>
                        <td><strong style="color: #7b2fae;">${{ number_format($finalTotal, 2) }}</strong></td>
                        <td></td>
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

{{-- ================= COMPACT STYLES ================= --}}
<style>
    html, body { max-width: 100%; overflow-x: hidden; }
    .order-page { 
        width: 100%; 
        max-width: 100%; 
        margin: 0 auto; 
        font-family: 'Poppins', sans-serif; 
        padding: 20px 30px; 
        min-height: 100vh; 
        background: linear-gradient(135deg, #fdfcff, #f6f0ff); 
    }
    
    /* FILTERS - More Compact */
    .filters-form { 
        display: flex; 
        gap: 14px; 
        background: white; 
        padding: 20px; 
        border-radius: 16px; 
        box-shadow: 0 10px 25px rgba(124,77,255,0.1); 
        margin-bottom: 30px; 
    }
    .filters-form div { flex:1; display:flex; flex-direction: column; }
    .filters-form label { font-size: 18px; font-weight: 600; color: #5b2a86; margin-bottom: 4px; }
    .filters-form select { padding: 8px 10px; border-radius: 8px; border: 1px solid #ddd; font-size: 13px; }
    .filters-form button { 
        background: linear-gradient(135deg, #7b2fae, #8f3f9b); 
        color: #fff; 
        border: none; 
        padding: 8px 24px; 
        border-radius: 8px; 
        font-weight: 600; 
        font-size: 16px;
        cursor: pointer; 
        align-self: flex-end;
    }
    
    /* ORDER CARD - More Compact */
    .order-card { 
        background: white; 
        border-radius: 16px; 
        padding: 20px; 
        margin-bottom: 25px; 
        box-shadow: 0 12px 30px rgba(124,77,255,0.1); 
    }
    .order-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        border-bottom: 1px solid #eee; 
        padding-bottom: 12px; 
        margin-bottom: 15px; 
    }
    .order-header h2 { margin:5px; font-size:20px; font-weight:700; color:#7b2fae; }
    .order-date { font-size:15px; color: #170202; }
    
    /* Loyalty Badge - Smaller */
    .loyalty-badge {
        display: inline-block;
        margin-left: 10px;
        padding: 3px 10px;
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    /* ===== STATUS BADGES - UPDATED WITH COLORS ===== */
    .status-badge { 
        display: inline-block;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
    }
    
    .status-pending {
        color: #856404;
        background-color: #fff3cd;
    }
    
    .status-delivered {
        color: #155724;
        background-color: #d4edda;
    }
    
    .status-shipped {
        color: #0c5460;
        background-color: #d1ecf1;
    }
    
    .status-processing {
        color: #0c1ccd;
        background-color: #e0e7ff;
    }
    
    .status-cancelled {
        color: #721c24;
        background-color: #f8d7da;
    }
    
    /* ===== COMPACT TABLE ===== */
    .order-table-wrapper { 
        width: 100%; 
        overflow-x: auto; 
    }
    
    .order-table { 
        width: 100%; 
        border-collapse: collapse; 
        font-size: 12px; 
    }
    
    .order-table th { 
        font-size: 18px; 
        color: #5b2a86; 
        text-transform: uppercase; 
        padding: 8px 5px; 
        background: #f3f0ff;
        border-bottom: 2px solid #d8d0ff;
        white-space: nowrap;
    }
    
    .order-table td { 
        padding: 8px 5px; 
        text-align: center; 
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        font-size: 16px;
    }
    
    /* Smaller Product Image */
    .table-img { 
        width: 70px; 
        height: 70px; 
        border-radius: 6px; 
        object-fit: cover; 
    }
    
    /* Compact Text Styles */
    .order-table td:first-child { 
        text-align: left; 
        font-weight: 500;
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .text-success { color: #10b981; font-weight: 600; }
    .text-muted { color: #9ca3af; }
    .text-delivery { color: #8b5cf6; font-weight: 600; }
    .total-cell { 
        font-weight: 700; 
        color: #7b2fae; 
        background: #f8f5ff;
        border-radius: 4px;
    }
    
    /* Summary Row - Compact */
    .summary-row {
        background: #f3f0ff;
        border-top: 2px solid #d8d0ff;
    }
    
    .summary-row td {
        padding: 10px 5px;
        font-weight: 700;
        font-size: 15px;
    }
    
    /* Report Button - Smaller */
    .report-btn { 
        padding: 4px 10px; 
        border-radius: 6px; 
        font-size: 10px; 
        font-weight: 600; 
        border: 1px solid #7b2fae; 
        color: #7b2fae; 
        text-decoration: none; 
        display: inline-block;
        white-space: nowrap;
    }
    .report-btn:hover { background:#7b2fae; color:#fff; }
    
    .pagination-wrapper { margin-top: 30px; display:flex; justify-content:center; }
    .no-orders { text-align: center; padding: 40px; color: #6b7280; }
    
    /* Responsive */
    @media (max-width: 768px) { 
        .filters-form { flex-direction: column; gap: 10px; } 
        .order-header { flex-direction: column; align-items:flex-start; gap:8px; } 
        .order-page { padding: 15px; }
        .order-table td { font-size: 18px; padding: 6px 3px; }
    }
</style>
@endsection