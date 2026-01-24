@extends('admin.layout')
@section('title','Order')
@section('content')
<div class="card p-3">
    <h6>Order #{{ $order->order_id }}</h6>
    <p><strong>Customer:</strong> {{ $order->customer->user->name }} {{ $order->customer->user->last_name }}</p>
    <p><strong>Total:</strong> {{ $order->total_amount }}</p>
    <p><strong>Status:</strong> {{ $order->order_status }}</p>

    <h6 class="mt-3">Items</h6>
    <ul>
        @foreach($order->items as $it)
            <li>{{ $it->product->product_name }} x {{ $it->quantity }} — {{ $it->price_at_purchase }}</li>
            <li>Shop: {{ $it->product->shop->shop_name }}</li>
            <li>Subtotal: {{ $it->quantity * $it->price_at_purchase }}</li>
           <li>
    <img src="{{ asset('storage/' . $it->product->image_url) }}" 
         alt="{{ $it->product->product_name }}" 
         width="100">
</li>

           
        @endforeach
</ul>

   
</div>
@endsection
