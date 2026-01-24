@extends('admin.layout')
@section('title','Customer Profile')

@section('content')
<div class="customer-profile-page">

    <!-- Header -->
    <div class="profile-header">
        <h2>Customer Profile</h2>
        <p>Overview of customer details and recent orders</p>
    </div>

    <div class="profile-content row">
        <!-- Left Column: Profile Info -->
        <div class="col-lg-4 col-md-12">
            <div class="card profile-card">
                <div class="avatar">
                    {{ strtoupper(substr($customer->user->name,0,1)) }}
                </div>
                <h4>{{ $customer->user->name }} {{ $customer->user->last_name }}</h4>
                <p class="email">{{ $customer->user->email }}</p>
                <p class="phone">{{ $customer->user->phone_number }}</p>
                <span class="registered">Registered: {{ $customer->created_at->format('Y-m-d') }}</span>
            </div>
        </div>

        <!-- Right Column: Orders Table -->
        <div class="col-lg-8 col-md-12">
            <div class="card orders-card">
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
    </div>

</div>

<style>
/* PAGE WRAPPER */
.customer-profile-page { padding: 30px; font-family: 'Poppins', sans-serif; background: #f9f9f9; }

/* HEADER */
.profile-header h2 { font-size: 28px; font-weight: 600; margin-bottom: 5px; }
.profile-header p { color: #777; margin-bottom: 20px; }

/* PROFILE CARD */
.profile-card { background: #fff; padding: 25px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 20px; }
.profile-card .avatar { width: 100px; height: 100px; background: #c08a56; border-radius: 50%; color: #fff; font-size: 36px; font-weight: bold; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; }
.profile-card h4 { margin-bottom: 5px; font-weight: 600; }
.profile-card p { margin: 2px 0; color: #555; }
.profile-card .registered { display: inline-block; margin-top: 10px; padding: 6px 14px; border-radius: 20px; background: #f1f1f1; color: #555; font-size: 13px; }

/* FILTERS */
.filters { display: flex; gap: 10px; margin-bottom: 15px; }
.filters select { padding: 6px 10px; border-radius: 8px; border: 1px solid #ccc; font-size: 14px; }

/* ORDERS TABLE */
.orders-card { background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
.orders-card h4 { margin-bottom: 15px; }
.orders-table { width: 100%; border-collapse: collapse; }
.orders-table thead { background: #f1f1f1; }
.orders-table th, .orders-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
.orders-table tbody tr:hover { background: #f9f9f9; }
.status { padding: 5px 10px; border-radius: 12px; font-size: 13px; font-weight: 500; display: inline-block; }
.status.pending { background: #fff3cd; color: #856404; }
.status.completed { background: #d4edda; color: #155724; }
.status.cancelled { background: #f8d7da; color: #721c24; }

/* TOGGLE BUTTON */
.btn-toggle-orders { margin-top: 15px; background: transparent; border: none; color: #c08a56; font-weight: 600; cursor: pointer; font-size: 14px; }
.btn-toggle-orders:hover { text-decoration: underline; }

/* RESPONSIVE */
@media (max-width: 992px) { .profile-content { flex-direction: column; } }
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
                // Show first 5 by default if not expanded
                row.style.display = (!expanded && visibleRows > 5) ? 'none' : 'table-row';
            } else {
                row.style.display = 'none';
            }
        });

        // Hide button if no extra rows
        if (visibleRows <= 5) {
            btn.style.display = 'none';
        } else {
            btn.style.display = 'inline-block';
            btn.innerText = expanded ? 'View Less' : 'View More';
        }
    }

    // Initial filter run
    filterOrders();

    // Filters event
    statusFilter.addEventListener('change', () => { expanded = false; filterOrders(); });
    shopFilter.addEventListener('change', () => { expanded = false; filterOrders(); });

    // View more button
    btn.addEventListener('click', () => {
        expanded = !expanded;
        filterOrders();
    });
});

</script>
@endsection
