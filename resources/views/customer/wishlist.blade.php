@extends('layouts.customer')

@section('content')
<section id="wishlist" class="content-section active">
  <h2>My Wishlist</h2>

  @if($wishlist && $wishlist->items->count() > 0)
  <div class="wishlist-grid">
    @foreach($wishlist->items as $item)
    <div class="wishlist-card">
      <a href="{{ route('product.show', $item->product->product_id) }}">
            <img src="{{ Str::startsWith($item->product->image_url, 'products/') 
                ? asset('storage/' . $item->product->image_url) 
                : asset($item->product->image_url) }}" 
                alt="{{ $item->product->product_name }}" 
                class="whishlist-img">
          </a>
      <h4>{{ $item->product->product_name }}</h4>
@php 
$price = $item->product->is_on_sale ? $item->product->discount_value : $item->product->price; @endphp @if($item->product->is_on_sale) <span style="color:red; font-weight:bold;"> ${{ number_format($item->product->discount_value, 2) }} </span> <br> <small style="text-decoration: line-through; color:#999;"> ${{ number_format($item->product->price, 2) }} </small> @else ${{ number_format($item->product->price, 2) }} @endif
      <div class="wishlist-actions">
        <form action="{{ route('cart.add', $item->product) }}" method="POST" class="add-to-cart-form">
    @csrf
    <button type="submit" class="quick-btn">Add to Cart</button>
</form>

      <form action="{{ route('wishlist.destroy', $item->wishlist_item_id) }}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-sm danger">Remove</button>
</form>

</form>

      </div>
    </div>
    @endforeach
  </div>
  @else
  <p>Your wishlist is empty. Save products you love!</p>
  @endif
  <style>
   .quick-btn {
        background-color: #6f340dc7;
        color: white;
        border: none;
        padding: 10px 15px 10px 15px;
       margin: 10px 10px 10px 0;
        cursor: pointer;
        border-radius: 15px;
        transition: background-color 0.3s ease;
    }
    .quick-btn:hover {
        background-color: #218838;
    }
  
  
</section>
@endsection
