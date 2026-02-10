@extends('layouts.customer')

@section('content')
<section id="cart" class="content-section active">

  <!-- Back Button -->
  <div class="back-btn-wrapper">
    
    <h2 class="center-title">My Shopping Cart</h2>
  </div>

  {{-- ================= FILTERS ================= --}}
  <form method="GET" class="cart-filters">
    <div class="filter-group">
      <label for="shopSelect">Filter by Shop:</label>
      <select name="shop_id" id="shopSelect">
        <option value="all">All Shops</option>
        @foreach($shops as $shop)
          <option value="{{ $shop->shop_id }}" {{ request('shop_id') == $shop->shop_id ? 'selected' : '' }}>
            {{ $shop->shop_name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="filter-group">
      <label for="searchItem">Search Item:</label>
      <input type="text" name="search" id="searchItem" value="{{ request('search') }}" placeholder="Search in cart...">
    </div>

    <button type="submit" class="apply-btn">Apply Filters</button>
  </form>

  @if($cartItems && $cartItems->count() > 0)
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
      @php
        $price = $item->product->is_on_sale ? $item->product->discount_value : $item->product->price;
      @endphp
      <tr>
<td>
  <a href="{{ route('product.show', $item->product->product_id) }}">
    @php
        $productImage = null;
        if ($item->product) {
            if ($item->product->images()->exists()) {
                $productImage = $item->product->images()->first()->image_path;
            } else {
                $productImage = $item->product->image_url;
            }
        }
    @endphp

    @if($productImage)
        <img src="{{ Str::startsWith($productImage,'products/') ? asset('storage/'.$productImage) : asset($productImage) }}" class="cart-img">
    @endif
  </a>

  <div class="product-info">
    <strong>{{ $item->product->product_name }}</strong>

    {{-- COLORS --}}
    @if($item->color)
      @php
        $colors = is_array($item->color) ? $item->color : explode(',', $item->color);
      @endphp
      <div class="item-option">
        Color:
        @foreach($colors as $color)
          <span class="color-badge" style="background:{{ trim($color) }}" title="{{ trim($color) }}"></span>
        @endforeach
      </div>
    @endif

    {{-- SIZES --}}
    @if($item->size)
      @php
        $sizes = is_array($item->size) ? $item->size : explode(',', $item->size);
      @endphp
      <div class="item-option">
        Size:
        @foreach($sizes as $size)
          <span>{{ trim($size) }}</span>
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

        <td>
          <form action="{{ route('cart.updateQuantity',$item) }}" method="POST" class="update-form horizontal">
            @csrf
            @method('PATCH')
            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">

{{-- CHANGE COLOR --}}
@if($item->product->color)
@php
  $colors = json_decode($item->product->color,true);
  if(!is_array($colors)){
      $colors = explode(',', $item->product->color);
  }
@endphp
<select name="color" class="option-select">
  @foreach($colors as $color)
    <option value="{{ trim($color) }}"
      {{ trim($color) == trim($item->color) ? 'selected' : '' }}>
      {{ trim($color) }}
    </option>
  @endforeach
</select>
@endif


{{-- CHANGE SIZE --}}
{{-- CHANGE SIZE --}}
@if($item->product->size)
@php
  $sizes = json_decode($item->product->size,true);
  if(!is_array($sizes)){
      $sizes = explode(',', $item->product->size);
  }
@endphp
<select name="size" class="option-select">
  @foreach($sizes as $size)
    <option value="{{ trim($size) }}"
      {{ trim($size) == trim($item->size) ? 'selected' : '' }}>
      {{ trim($size) }}
    </option>
  @endforeach
</select>
@endif



            <button class="update-btn">Update</button>
          </form>
        </td>

        <td>${{ number_format($price * $item->quantity, 2) }}</td>

        <td>
          <form action="{{ route('cart.remove',$item) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn-sm danger">Remove</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
   <div class="pagination-wrapper">
        {{ $cartItems->links('pagination::simple-tailwind') }}
    </div>

  {{-- CART TOTAL --}}
  <div class="cart-summary">
    <strong>Total: </strong>${{ number_format($cartItems->sum(fn($i)=>($i->product->is_on_sale?$i->product->discount_value:$i->product->price)*$i->quantity),2) }}
    <br>
    <a href="{{ route('checkout') }}" class="checkout-btn">Proceed to Checkout</a>
  </div>


  @else
    <p class="empty-cart-msg">Your cart is empty. Start shopping now!</p>
  @endif

</section>

<style>
  .back-btn-wrapper {
  margin-bottom: 25px;
}


.back-btn {
  display: inline-flex;
  align-items: center;

  padding: 10px 18px;
  background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
  color: #fff;
  font-weight: 600;
  font-size:20px;
  border-radius: 12px;
  text-decoration: none;
  box-shadow: 0 8px 25px rgba(124,77,255,0.25);
  transition: all 0.3s ease;
}

.back-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(96,165,250,0.35);
  color: #fff;
}
  .pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination-wrapper nav {
    display: flex;
    gap: 10px;
}

.pagination-wrapper a,
.pagination-wrapper span {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid var(--border-soft);
    color: var(--text-dark);
    font-weight: 500;
    text-decoration: none;
}

.pagination-wrapper .disabled {
    opacity: 0.5;
    pointer-events: none;
}

.pagination-wrapper .active {
    background: var(--purple-soft);
    color: #fff;
    border-color: var(--purple-soft);
}





.content-section{padding:30px;max-width:1150px;margin:auto;background:#fff;border-radius:18px;box-shadow:var(--shadow-soft)}

/* Filters */
.cart-filters{display:flex;gap:12px;justify-content:center;margin-bottom:25px;flex-wrap:wrap}
.filter-group label{font-weight:600;color:var(--text-muted)}
.cart-filters input, .cart-filters select{padding:10px;border-radius:10px;border:1px solid var(--border-soft)}
.apply-btn{background:linear-gradient(135deg,var(--purple-soft),var(--blue-soft));color:#fff;border:none;padding:10px 22px;border-radius:12px}

/* TABLE → CARD LOOK */
.cart-table{
  width:100%;
  border-collapse:separate;
  border-spacing:0 16px;
}

.cart-table thead{display:none;}

.cart-table tbody tr{
  background:#fff;
  box-shadow:0 10px 30px rgba(0,0,0,.08);
  border-radius:16px;
}

.cart-table td{
  border:none;
  padding:16px;
  vertical-align:middle;
}

.cart-table td:first-child{
  border-radius:16px 0 0 16px;
}
.cart-table td:last-child{
  border-radius:0 16px 16px 0;
  text-align:right;
}

/* product image */
.cart-img{
  width:90px;
  height:90px;
  border-radius:12px;
  object-fit:cover;
  margin-right:12px;
}

/* options */
.item-option{font-size:13px;color:var(--text-muted)}
.color-badge{
  width:14px;height:14px;border-radius:50%;
  display:inline-block;border:1px solid #ccc;margin-right:4px;
}

/* price */
.sale-price{color:#ef4444;font-weight:700}
.old-price{text-decoration:line-through;color:#9ca3af;font-size:12px}
.normal-price{font-weight:600}

/* qty form */
.update-form.horizontal{
  display:flex;gap:8px;align-items:center;flex-wrap:wrap
}
.update-btn{
  background:var(--purple-soft);
  color:#fff;border:none;border-radius:8px;padding:6px 14px
}

/* remove */
.btn-sm.danger{
  background:#ef4444;color:#fff;border:none;border-radius:8px;padding:8px 16px
}

/* total */
.cart-summary{text-align:right;font-size:18px;font-weight:700;margin-top:25px}

/* responsive */
@media(max-width:768px){
.cart-table tbody tr{display:flex;flex-direction:column}
.cart-table td:last-child{text-align:left}
}

/* ===== SELECT OPTIONS (Color & Size) ===== */
.option-select {
  padding: 6px 12px;
  border-radius: 8px;
  border: 1px solid var(--border-soft);
  font-size: 14px;
  background: #fff;
  color: var(--text-dark);
  cursor: pointer;
  transition: 0.25s;
  min-width: 100px;
}

.option-select:focus {
  outline: none;
  border-color: var(--purple-soft);
  box-shadow: 0 0 6px rgba(124,77,255,0.3);
}

/* Color select – show a small color box inside select */
.option-select.color-select {
  padding-left: 30px;
  position: relative;
}

.option-select.color-select option {
  padding-left: 10px;
}

/* Style the wrapper of select in form */
.update-form select {
  margin-top: 4px;
}

/* Add label before select */
.update-form select + label {
  font-size: 13px;
  color: var(--text-muted);
  margin-right: 6px;
}

</style>

@endsection