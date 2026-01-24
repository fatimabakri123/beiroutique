@extends('admin.layout')

@section('title', 'Product Details')

@section('content')
<div class="card p-4">
    <h3>{{ $product->product_name }}</h3>

    <img src="{{ asset('/storage/' . $product->image_url) }}" 
         alt="{{ $product->product_name }}" 
         width="200">

    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
    <p><strong>SKU:</strong> {{ $product->sku }}</p>
</div>
@endsection
