@extends('admin.layout')

@section('title','Search results')

@section('content')
<div class="search-results">
    

    <h3>Search results for "{{ $q }}"</h3>

   {{-- Products Section --}}
@if($products->count())
<h5>Products</h5>
<div class="cards-container">
    @foreach($products as $p)
    <div class="card">
        <img src="{{ asset('storage/' . $p->image_url) }}" alt="{{ $p->product_name }}">
        <h6>{{ $p->product_name }}</h6>
        <p>Shop: {{ $p->shop->shop_name }}</p>
        <p>${{ $p->price }}</p>
    </div>
    @endforeach
</div>
@endif

{{-- Shops Section --}}
@if($shop->count())
<h5>Shops</h5>
<div class="cards-container">
    @foreach($shop as $s)
    <div class="card">
        <img src="{{ asset('storage/' . $s->logo_url) }}" alt="{{ $s->shop_name }}">
        <h6>{{ $s->shop_name }}</h6>
        <p>{{ $s->description }}</p>
    </div>
    @endforeach
</div>
@endif

{{-- Customers Section --}}
@if($customers->count())
<h5>Customers</h5>
<div class="list-container">
    <ul>
        @foreach($customers as $c)
            <li class="customer-item">
                <a href="{{ route('admin.customers.show', $c->id) }}" class="customer-name">
                    {{ $c->name }}
                </a>

                <div class="customer-meta">
                    <span>{{ $c->email }}</span>
                    <span>{{ $c->created_at->format('Y-m-d') }}</span>
                </div>
            </li>
        @endforeach
    </ul>

    <style>
        .customer-item {
    padding: 12px 15px;
    border-bottom: 1px solid #e5e7eb;
}

.customer-item:last-child {
    border-bottom: none;
}

.customer-name {
    display: inline-block;
    font-weight: 600;
    font-size: 1.05rem;
    color: #2563eb;
    text-decoration: none;
    margin-bottom: 4px;
}

.customer-name:hover {
    text-decoration: underline;
    color: #1d4ed8;
}

.customer-meta {
    font-size: 0.9rem;
    color: #6b7280;
    display: flex;
    gap: 15px;
}
    </style>
</div>

@endif

{{-- Shop Owners Section --}}
@if($shop_owners->count())
<h5>Shop Owners</h5>
<div class="list-container">
    <ul>
        @foreach($shop_owners as $s)
        <li>{{ $s->name }}</li>
        @endforeach
    </ul>
</div>
@endif
<style>
  
/* General */
.search-results {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
    font-family: '';
    color: #1f2937;
    font-weight: 15px;
}

.search-results h3 {
    font-size: 2rem;
    margin-bottom: 20px;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 5px;
    font-family: '';
}

.search-results h5 {
    font-size: 1.5rem;
    margin-top: 30px;
    margin-bottom: 15px;
    color: #111827;
    border-left: 4px solid #3b82f6;
    padding-left: 10px;
}

/* Product & Shop Cards */
.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    text-align: center;
    padding: 15px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}
.card img {
    width: 150px;        
    height: 150px;
    object-fit: cover;
    border-radius: 12px;
    margin: 10px auto;  
    display: block;
    background: #f3f4f6;
}


.card h6 {
    font-size: 25px;
    margin: 5px 0;
  
}

.card p {
    font-size: 30px;
    color: #6b7280;
}

/* Customers & Shop Owners List */
.list-container {
    background: #fff;
    padding: 15px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.list-container ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.list-container li {
    padding: 8px 12px;
    border-bottom: 1px solid #e5e7eb;
    font-size:20px;
}

.list-container li:last-child {
    border-bottom: none;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .cards-container {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
    .card img {
        height: 120px;
    }
}
</style>


</div>
@endsection
