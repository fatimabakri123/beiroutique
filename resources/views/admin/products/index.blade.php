@extends('admin.layout')
@section('title','Products')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>Products</h5>
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.products.pending') }}">Pending</a>
</div>

<div class="card p-3">

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3 d-flex gap-2 flex-wrap">
        <select name="category_id" class="form-select form-select-sm w-auto">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>

        <select name="shop_id" class="form-select form-select-sm w-auto">
            <option value="">All Shops</option>
            @foreach($shops as $shop)
                <option value="{{ $shop->shop_id }}" {{ request('shop_id') == $shop->shop_id ? 'selected' : '' }}>
                    {{ $shop->shop_name }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-sm btn-outline-primary">Filter</button>
    </form>

    {{-- Products list --}}
    <div class="products-list">
        @foreach($products as $p)
        <div class="product-card">
            <div class="product-info">
                <div class="avatar">
                    @php
                        $image = null;

                        if ($p->images && $p->images->count()) {
                            $image = $p->images->first()->image_path;
                        } elseif (!empty($p->image_url)) {
                            $image = $p->image_url;
                        }
                    @endphp

                    @if($image)
                        <img
                            src="{{ Str::startsWith($image, 'products/')
                                    ? asset('storage/'.$image)
                                    : asset($image) }}"
                            alt="{{ $p->product_name }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No image">
                    @endif
                </div>

                <div class="details">
                    <h6>{{ $p->product_name }}</h6>
                    <p>Shop: {{ $p->shop->shop_name ?? 'N/A' }}</p>
                    <p>Category: {{ $p->category->category_name ?? '-' }}</p>
                    <p>Price: <strong>{{ $p->price }}</strong></p>
                    <p>Stock: <strong>{{ $p->stock_quantity }}</strong></p>
                    <p>Status: {{ $p->is_on_sale ? 'On Sale':'Active' }}</p>
                </div>
            </div>

            <div class="product-actions">
                <a href="{{ route('admin.products.show',$p->product_id) }}" class="btn btn-view">View</a>
                <form action="{{ route('admin.products.destroy',$p->product_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete" onclick="return confirm('Remove this product?')">Remove</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center gap-2 mt-3">
        @if ($products->onFirstPage())
            <button class="btn btn-outline-secondary" disabled>&lt;</button>
        @else
            <a href="{{ $products->previousPageUrl() }}" class="btn btn-outline-primary">&lt;</a>
        @endif

        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="btn btn-outline-primary">&gt;</a>
        @else
            <button class="btn btn-outline-secondary" disabled>&gt;</button>
        @endif
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
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
}

.product-info .details h6 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #6311ac;
}
.product-info .details p {
    margin: 2px 0;
    font-size: 16px;
    color: #555;
}

.product-actions {
    display: flex;
    gap: 10px;
}
.btn-view, .btn-delete {
    font-size: 13px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 12px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-view {
    border-color: #7b2fae;
    color: #7b2fae;
    background: transparent;
    font-size: 18px;
}
.btn-view:hover {
    background: linear-gradient(135deg,#7b2fae,#a64dd1);
    color: #fff;
    box-shadow: 0 8px 22px rgba(124,77,255,0.4);
    transform: translateY(-2px) scale(1.05);
}
.btn-delete {
    border-color: #dc2626;
    color: #dc2626;
    background: transparent;
    font-size: 18px;
}
.btn-delete:hover {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 6px 20px rgba(220,38,38,0.4);
    transform: translateY(-2px) scale(1.05);
}

@media(max-width:768px){
    .product-card { flex-direction: column; align-items: flex-start; }
    .product-actions { margin-top: 10px; width: 100%; justify-content: flex-start; gap: 8px; }
    .product-info .avatar img { width: 40px; height: 40px; }
}

</style>

@endsection
