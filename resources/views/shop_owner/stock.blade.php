@extends('shop_owner.layout')

@section('content')
<div class="container" style="max-width:600px; margin-top:30px;">
    <div class="card" style="padding:20px;">
        <h3>Edit Stock: {{ $product->product_name }}</h3>

        <form action="{{ route('shop.product.update-stock', $product->product_id) }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom:15px;">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" 
                    value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;">
                @error('stock_quantity')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn" style="background:#4e73df; color:#fff; padding:10px 15px; border-radius:5px;">Update Stock</button>
            <a href="{{ route('shop.stats') }}" class="btn" style="margin-left:10px; padding:10px 15px; border-radius:5px; background:#ddd; color:#333; text-decoration:none;">Cancel</a>
        </form>
    </div>
</div>
@endsection