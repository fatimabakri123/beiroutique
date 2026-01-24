@extends('layouts.customer')

@section('content')
<section id="dashboard-home" class="content-section active">
    <h1>Welcome, {{ $user->name }} 👋</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fa fa-box"></i>
            <h3>Orders</h3>
            <p>{{ $ordersCount ?? 0 }} Active Orders</p>
        </div>

        <div class="stat-card">
            <i class="fa fa-heart"></i>
            <a href="{{ route('customer.wishlist') }}">
                <h3>Wishlist</h3>
            </a>
            <p>{{ $wishlistCount ?? 0 }} Items Saved</p>
        </div>

        <div class="stat-card">
            <i class="fa fa-bell"></i>
            <h3>Notifications</h3>
            <p>{{ $notifications->count() ?? 0 }} New Alerts</p>
        </div>
    </div>
</section>

@endsection
