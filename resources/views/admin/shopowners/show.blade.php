@extends('admin.layout')
@section('title','Shop Owner Profile')
@section('content')

<div class="card profile-card p-4">

    {{-- Owner Basic Info --}}
    <div class="owner-info text-center mb-4">
        <div class="avatar">{{ strtoupper(substr($owner->user->name,0,1)) }}</div>
        <h3 class="owner-name">{{ $owner->user->name }}</h3>
        <p class="owner-email">{{ $owner->user->email }} — {{ $owner->phone_number }}</p>
    </div>

    <hr>

    {{-- Statistics --}}
    <div class="owner-stats mb-4">
        <h5>Statistics</h5>
        <ul>
            <li>Total Shops: <strong>{{ $owner->shops?->count() ?? 0 }}</strong></li>
            <li>Total Products: <strong>{{ $owner->shops->sum(fn($s) => $s->products?->count() ?? 0) }}</strong></li>
            <li>Total Orders: <strong>{{ $owner->shops->sum(fn($s) => $s->orders_count ?? 0) }}</strong></li>
        </ul>
    </div>

    <hr>

    {{-- Shops List --}}
    <div class="owner-shops mb-4">
        <h5>Shops</h5>
        <ul>
            @foreach($owner->shops as $s)
            <li class="shop-item">
                <strong>{{ $s->shop_name }}</strong> — 
                <span class="{{ $s->is_active ? 'active-status' : 'pending-status' }}">
                    {{ $s->is_active ? 'Active' : 'Pending' }}
                </span>  
                — Products: {{ $s->products?->count() ?? 0 }}  
                — Orders: {{ $s->orders_count ?? 0 }}

                <a href="{{ route('admin.shops.show', $s->shop_id) }}" class="btn btn-view-shop ms-2">View Shop</a>
            </li>
            @endforeach
        </ul>
    </div>

    <hr>

    <div class="text-center">
        <a href="{{ route('admin.shopowners.index') }}" class="btn btn-back">Back to Shop Owners</a>
    </div>

</div>

<style>
/* ===== CARD ===== */
.profile-card {
    border-radius: 18px;
    background: linear-gradient(135deg, #ffffff, #f8f5ff);
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.profile-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(124,77,255,0.15);
}

/* ===== OWNER INFO ===== */
.owner-info .avatar {
    width: 100px;
    height: 100px;
    background: #7b2fae;
    border-radius: 50%;
    color: #fff;
    font-size: 40px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
}
.owner-name { font-size: 24px; font-weight: 600; margin-bottom: 5px; }
.owner-email { color: #555; }

/* ===== STATS ===== */
.owner-stats ul { list-style: none; padding-left: 0; }
.owner-stats li { margin: 8px 0; font-size: 14px; color: #333; }
.owner-stats strong { color: #7b2fae; }

/* ===== SHOPS ===== */
.owner-shops ul { list-style: none; padding-left: 0; }
.shop-item { 
    background: #fdfcff; 
    padding: 10px 15px; 
    margin-bottom: 10px; 
    border-radius: 12px; 
    display: flex; 
    flex-wrap: wrap; 
    align-items: center; 
    transition: all 0.3s ease; 
    box-shadow: 0 6px 15px rgba(124,77,255,0.08);
}
.shop-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(124,77,255,0.2);
}

.active-status {
    color: #155724;
    background: #d4edda;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
}
.pending-status {
    color: #856404;
    background: #fff3cd;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
}

/* ===== BUTTONS ===== */
.btn-view-shop {
    font-size: 13px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 12px;
    border: 2px solid #7b2fae;
    color: #7b2fae;
    background: transparent;
    transition: all 0.3s ease;
}
.btn-view-shop:hover {
    background: linear-gradient(135deg, #7b2fae, #a64dd1);
    color: #fff;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 8px 22px rgba(124,77,255,0.4);
}

.btn-back {
    font-size: 14px;
    font-weight: 600;
    padding: 8px 20px;
    border-radius: 14px;
    border: 2px solid #555;
    color: #555;
    background: transparent;
    transition: all 0.3s ease;
}
.btn-back:hover {
    background: #555;
    color: #fff;
    transform: translateY(-2px) scale(1.05);
}

/* ===== RESPONSIVE ===== */
@media(max-width: 768px){
    .shop-item { flex-direction: column; align-items: flex-start; }
    .btn-view-shop { margin-top: 6px; }
}
</style>

@endsection
