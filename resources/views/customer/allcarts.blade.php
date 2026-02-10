@extends('layouts.customer')

@section('content')
<section class="content-section">
  <div class="back-btn-wrapper">
    <a href="{{ url()->previous() }}" class="back-btn"><i class="fa fa-arrow-left"></i> Back</a>
  </div>

  <h2 class="center-title">All Cart Items</h2>

  @if($cartItems->count() > 0)
    <table class="cart-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Qty / Options</th>
          <th>Total</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($cartItems as $item)
          @if($item->product)
            @php 
              $price = $item->product->is_on_sale ? $item->product->discount_value : $item->product->price; 
            @endphp
            <tr>
              <td>
                <a href="{{ route('product.show', $item->product->product_id) }}">
                  <img src="{{ Str::startsWith($item->product->image_url,'products/') ? asset('storage/'.$item->product->image_url) : asset($item->product->image_url) }}" class="cart-img">
                </a>
                <div class="product-info">
                  <strong>{{ $item->product->product_name }}</strong>
                  @if($item->color)
                    <div class="item-option">
                      Color: 
                      @php
                        $colors = is_array($item->color) ? $item->color : explode(',', $item->color);
                      @endphp
                      @foreach($colors as $color)
                        <span class="color-badge" style="background:{{ trim($color) }}"></span>{{ trim($color) }}
                      @endforeach
                    </div>
                  @endif
                  @if($item->size)
                    <div class="item-option">
                      Size: 
                      @php
                        $sizes = is_array($item->size) ? $item->size : explode(',', $item->size);
                      @endphp
                      @foreach($sizes as $size)
                        {{ trim($size) }}
                      @endforeach
                    </div>
                  @endif
                </div>
              </td>
              <td>
                @if($item->product->is_on_sale)
                  <span class="sale-price">${{ number_format($price,2) }}</span>
                  <small class="old-price">${{ number_format($item->product->price,2) }}</small>
                @else
                  <span class="normal-price">${{ number_format($price,2) }}</span>
                @endif
              </td>
              <td>{{ $item->quantity }}</td>
              <td>${{ number_format($price * $item->quantity, 2) }}</td>
              <td>
                <form action="{{ route('cart.remove', $item) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn-sm danger">Remove</button>
                </form>
              </td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>

    <div class="cart-summary">
      <strong>Total: </strong>$
      {{ number_format($cartItems->sum(fn($i) => ($i->product ? ($i->product->is_on_sale ? $i->product->discount_value : $i->product->price) * $i->quantity : 0)), 2) }}

    </div>

  @else
    <p class="empty-cart-msg">No items in cart.</p>
  @endif
</section>

<style>
.cart-table{width:100%;border-collapse:collapse;margin-top:20px;}
.cart-table th, .cart-table td{padding:12px;border-bottom:1px solid #ddd;}
.cart-img{width:60px;height:60px;object-fit:cover;border-radius:10px;margin-right:10px;}
.product-info{display:inline-block;vertical-align:middle;}
.item-option{font-size:14px;color:#555;margin-top:2px;}
.color-badge{display:inline-block;width:14px;height:14px;border-radius:50%;border:1px solid #ccc;margin-right:4px;vertical-align:middle;}
.btn-sm.danger{background:#ef4444;color:#fff;padding:6px 12px;border:none;border-radius:6px;cursor:pointer;}
.btn-sm.danger:hover{background:#dc2626;}
.cart-summary{margin-top:20px;font-weight:600;font-size:16px;text-align:right;}
.back-btn-wrapper{margin-bottom:20px;}
.back-btn{background:#6b5b95;color:#fff;padding:8px 16px;border-radius:8px;text-decoration:none;}
.center-title{text-align:center;margin-bottom:20px;}
</style>
@endsection
