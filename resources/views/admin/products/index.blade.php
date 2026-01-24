@extends('admin.layout')
@section('title','Products')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Products</h5>
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.products.pending') }}">Pending</a>
</div>
<div class="card p-2">
    {{-- Filters --}}
<form method="GET" action="{{ route('admin.products.index') }}" class="mb-3 d-flex gap-2">
    <select name="category_id" class="form-select form-select-sm">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>

    <select name="shop_id" class="form-select form-select-sm">
        <option value="">All Shops</option>
        @foreach($shops as $shop)
            <option value="{{ $shop->shop_id }}" {{ request('shop_id') == $shop->shop_id ? 'selected' : '' }}>
                {{ $shop->shop_name }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-sm btn-outline-primary">Filter</button>
</form>
    <table class="table">
        <thead><tr><th>ID</th><th>Product</th><th>Shop</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Shop</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->product_id }}</td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->shop->shop_name ?? '-' }}</td>
                <td>{{ $p->category->category_name ?? '-' }}</td>
                <td>{{ $p->price }}</td>
                <td>{{ $p->stock_quantity }}</td>
                <td>{{ $p->is_on_sale ? 'On Sale':'Active' }}</td>
                <td>{{ $p->shop->shop_name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.products.show',$p->product_id) }}" class="btn btn-sm btn-outline-primary">View</a>
                    <form action="{{ route('admin.products.destroy',$p->product_id) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Remove</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection
