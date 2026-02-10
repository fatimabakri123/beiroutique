@extends('shop_owner.layout')
@section('title', 'Edit Stock')

@section('content')
<div class="edit-stock-page">
    <div class="edit-stock-card">
        <h3>Edit Stock: {{ $product->product_name }}</h3>

        <form action="{{ route('shop.product.update-stock', $product->product_id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity" 
                       value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0">
                @error('stock_quantity')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Stock</button>
            <a href="{{ route('shop_owner.statistics') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<style>

    .edit-stock-page {
    display: flex;
    justify-content: center;      /* center horizontally */
    align-items: flex-start;      /* align top */
    padding: 50px 20px;           /* space around the card */
    min-height: calc(100vh - 50px); /* fills most of the screen */
    background-color: var(--bg-light); /* soft background */
}

.edit-stock-card {
    background-color: var(--white);
    padding: 40px 30px;          /* bigger padding inside card */
    border-radius: 15px;
    box-shadow: var(--shadow-soft);
    width: 100%;
    max-width: 600px;            /* keeps it readable on large screens */
}

.edit-stock-card h3 {
    font-size: 28px;
    font-weight: 700;
    color: var(--purple-dark);
    margin-bottom: 25px;
    text-align: center;
}

.edit-stock-card label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 5px;
    display: block;
}

.edit-stock-card input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid var(--border-soft);
    margin-bottom: 15px;
    font-size: 16px;
}

.edit-stock-card button {
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
}

.edit-stock-card .btn-primary,
.edit-stock-card .btn-secondary {
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700; /* bold text */
    cursor: pointer;
    border: none;
    text-decoration: none;
}

/* Update Stock button */
.edit-stock-card .btn-primary {
    background-color: var(--purple-dark);
    color: var(--white);
}

.edit-stock-card .btn-primary:hover {
    background-color: var(--purple-soft);
}

/* Cancel button now looks like Update Stock */
.edit-stock-card .btn-secondary {
    background-color: var(--purple-dark);
    color: var(--white);
    margin-left: 10px; /* spacing between buttons */
}

.edit-stock-card .btn-secondary:hover {
    background-color: var(--purple-soft);
}
    </style>
@endsection