@extends('admin.layout')
@section('title','Shop Details')

@section('content')
 <div style="margin-bottom: 20px;">
        <a href="{{ url()->previous() }}" class="btn-back">← Back</a>
        <style>
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
        </style>
    </div>
<div class="d-flex justify-content-between mb-3">
    <h5>{{ $shop->shop_name }}</h5>
</div>

<div class="card p-3">
    <p>{{ $shop->description }}</p>
    <p><strong>Owner:</strong> {{ $shop->owner->user->name }}</p>

    <h6 class="mt-3">Products</h6>

    <div class="products-list">

        @foreach($products as $p)

            @php
                $images = collect();

                if ($p->images && $p->images->count()) {
                    $images = $p->images;
                } elseif (!empty($p->image_url)) {
                    $images = collect([(object)['image_path' => $p->image_url]]);
                }
            @endphp

            <div class="product-card">
                <div class="product-info">

                    <div class="avatar">
                        @if($images->count())
                            <img
                                src="{{ Str::startsWith($images->first()->image_path,'products/')
                                        ? asset('storage/'.$images->first()->image_path)
                                        : asset($images->first()->image_path) }}"
                                alt="{{ $p->product_name }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No image">
                        @endif
                    </div>

                    <div class="details">
                        <h6>{{ $p->product_name }}</h6>
                        <p>Price: <strong>{{ $p->price }}</strong></p>
                        <p>Stock: <strong>{{ $p->stock_quantity }}</strong></p>
                        <p>Category: {{ $p->category->category_name ?? '-' }}</p>
                        <p>Subcategory: {{ optional($p->subcategory)->subcategory_name ?? 'N/A' }}</p>
                        <p>{{ $p->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
.products-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.product-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 15px 20px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(124,77,255,0.08);
    transition: all 0.3s ease;
}
.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(124,77,255,0.18);
}

.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.product-info .avatar img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}

.product-info .details h6 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #6311ac;
}
.product-info .details p {
    margin: 2px 0;
    font-size: 13px;
    color: #555;
}

@media (max-width: 768px) {
    .product-card { flex-direction: column; align-items: flex-start; }
    .product-info .avatar img { width: 40px; height: 40px; }
}
</style>

@endsection
