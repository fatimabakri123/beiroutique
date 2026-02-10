@extends('admin.layout')
@section('title','Customer Profile')

@section('content')
<div class="customer-profile-page">

    <!-- Back Button -->
    <div style="margin-bottom: 20px;">
        <a href="{{ url()->previous() }}" class="btn-back">← Back</a>
    </div>

    <!-- Header -->
    <div class="profile-header">
        <h2>Customer Profile</h2>
        <p>Overview of customer details and recent orders</p>
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="avatar">
            {{ strtoupper(substr($customer->user->name,0,1)) }}
        </div>
        <h4>{{ $customer->user->name }} {{ $customer->user->last_name }}</h4>
        <p class="email">{{ $customer->user->email }}</p>
        <p class="phone">{{ $customer->user->phone_number }}</p>
        <span class="registered">Registered: {{ $customer->created_at->format('Y-m-d') }}</span>
    </div>

    <!-- Recent Orders Section -->
    <div class="orders-card">
        <h4>Recent Orders</h4>

        <!-- Filters -->
        <div class="filters">
            <select id="statusFilter">
                <option value="all">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="delivered">Delivered</option>
                <option value="processing">Processing</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <select id="shopFilter">
                <option value="all">All Shops</option>
                @php
                    $shops = $orders->flatMap(fn($o) => $o->items->pluck('product.shop.shop_name'))->filter()->unique();
                @endphp
                @foreach($shops as $shop)
                    <option value="{{ $shop }}">{{ $shop }}</option>
                @endforeach
            </select>
        </div>

        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Amount</th>
                        <th>Shops</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                    <tr data-status="{{ strtolower($o->order_status) }}" data-shops="{{ $o->items->pluck('product.shop.shop_name')->filter()->unique()->implode(', ') }}">
                        <td>#{{ $o->order_id }}</td>
                        <td>${{ $o->total_amount }}</td>
                        <td>{{ $o->items->pluck('product.shop.shop_name')->filter()->unique()->implode(', ') ?: 'N/A' }}</td>
                        <td>{{ $o->items->count() }}</td>
                        <td>
                            <span class="status {{ strtolower($o->order_status) }}">
                                {{ ucfirst($o->order_status) }}
                            </span>
                        </td>
                        <td>{{ $o->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($orders->count() > 5)
            <button class="btn-toggle-orders" id="toggleOrdersBtn" onclick="toggleOrders()">View More</button>
        @endif
    </div>

</div>

<!-- CSS -->
<style>
    /* Back Button */
.btn-back { 
    display: inline-block; 
    padding: 8px 16px; 
    border-radius: 10px; 
    background: #fff; 
    border: 2px solid #7b2fae; 
    color: #7b2fae; 
    font-weight: 600; 
    text-decoration: none; 
    transition: all 0.3s ease; 
}
.btn-back:hover { 
    background: linear-gradient(135deg, #7b2fae, #a64dd1); 
    color: #fff; 
    transform: translateY(-2px) scale(1.05); 
    box-shadow: 0 6px 18px rgba(124,77,255,0.4); 
}

/* ===== PAGE WRAPPER ===== */
.customer-profile-page { padding: 30px; font-family: 'Poppins', sans-serif; background: #f9f9f9; }

/* HEADER */
.profile-header h2 { font-size: 30px; font-weight: 700; margin-bottom: 5px; color: #6311ac; }
.profile-header p { color: #666; margin-bottom: 25px; font-size: 16px; }

/* PROFILE CARD */
.profile-card { background: #fff; padding: 30px 20px; border-radius: 18px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.08); margin-bottom: 30px; transition: all 0.3s ease; }
.profile-card:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(124,77,255,0.2); }
.profile-card .avatar { width: 110px; height: 110px; background: #7b2fae; border-radius: 50%; color: #fff; font-size: 42px; font-weight: bold; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; }
.profile-card h4 { margin-bottom: 5px; font-weight: 600; font-size: 22px; color: #3a0d6a; }
.profile-card p { margin: 3px 0; color: #555; font-size: 15px; }
.profile-card .registered { display: inline-block; margin-top: 12px; padding: 7px 16px; border-radius: 20px; background: #f1f1f1; color: #555; font-size: 13px; font-weight: 500; }

/* FILTERS */
.filters { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
.filters select { padding: 8px 12px; border-radius: 10px; border: 1px solid #ccc; font-size: 16px; outline: none; transition: all 0.3s ease; }
.filters select:focus { border-color: #7b2fae; box-shadow: 0 0 8px rgba(123,47,174,0.3); }

/* ORDERS CARD */
.orders-card { background: #fff; padding: 25px; border-radius: 18px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); transition: all 0.3s ease; margin-bottom: 30px; }
.orders-card:hover { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(124,77,255,0.15); }
.orders-card h4 { margin-bottom: 18px; font-size: 22px; font-weight: 600; color: #6311ac; }

/* ORDERS TABLE */
.table-responsive { overflow-x: auto; }
.orders-table { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
.orders-table thead { background: #7b2fae33; }
.orders-table th, .orders-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-size: 16px; color: #333; }
.orders-table tbody tr { background: #fff; border-radius: 12px; transition: all 0.3s ease; }
.orders-table tbody tr:hover { background: #f7f2ff; }

/* STATUS BADGES */
.status { padding: 6px 14px; border-radius: 14px; font-size: 16px; font-weight: 500; display: inline-block; text-transform: capitalize; }
.status.pending { background: #fff3cd; color: #856404; }
.status.delivered { background: #d4edda; color: #155724; }
.status.processing { background: #cce5ff; color: #004085; }
.status.cancelled { background: #f8d7da; color: #721c24; }

/* TOGGLE BUTTON */
.btn-toggle-orders { margin-top: 20px; background: #fff; border: 2px solid #7b2fae; border-radius: 12px; color: #7b2fae; font-weight: 600; cursor: pointer; font-size: 14px; padding: 8px 20px; transition: all 0.3s ease; }
.btn-toggle-orders:hover { background: linear-gradient(135deg, #7b2fae, #a64dd1); color: #fff; box-shadow: 0 6px 18px rgba(124,77,255,0.4); transform: translateY(-2px) scale(1.05); }

/* RESPONSIVE */
@media (max-width: 992px) { .profile-content { flex-direction: column; } }
@media (max-width: 576px) { .orders-table th, .orders-table td { font-size: 13px; padding: 10px; } .profile-card h4 { font-size: 20px; } .profile-card .avatar { width: 90px; height: 90px; font-size: 36px; } .btn-toggle-orders { font-size: 13px; padding: 6px 16px; } }
</style>

<script>
let expanded = false;

document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('.orders-table tbody tr');
    const btn = document.getElementById('toggleOrdersBtn');
    const statusFilter = document.getElementById('statusFilter');
    const shopFilter = document.getElementById('shopFilter');

    function filterOrders() {
        const statusVal = statusFilter.value.toLowerCase();
        const shopVal = shopFilter.value.toLowerCase();
        let visibleRows = 0;

        tableRows.forEach(row => {
            const rowStatus = row.dataset.status.toLowerCase();
            const rowShops = row.dataset.shops.toLowerCase();
            const statusMatch = (statusVal === 'all') || (rowStatus === statusVal);
            const shopMatch = (shopVal === 'all') || (rowShops.includes(shopVal));

            if (statusMatch && shopMatch) {
                visibleRows++;
                row.style.display = (!expanded && visibleRows > 5) ? 'none' : 'table-row';
            } else {
                row.style.display = 'none';
            }
        });

        if (visibleRows <= 5) {
            btn.style.display = 'none';
        } else {
            btn.style.display = 'inline-block';
            btn.innerText = expanded ? 'View Less' : 'View More';
        }
    }

    filterOrders();
    statusFilter.addEventListener('change', () => { expanded = false; filterOrders(); });
    shopFilter.addEventListener('change', () => { expanded = false; filterOrders(); });
    btn.addEventListener('click', () => { expanded = !expanded; filterOrders(); });
});
</script>
@endsection
