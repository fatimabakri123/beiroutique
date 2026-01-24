@extends('layouts.customer')

@section('content')
<section id="cart" class="content-section active">
  <h2>My Shopping Cart</h2>

  {{-- ================= FILTERS ================= --}}
  <form method="GET" class="cart-filters">
    {{-- Shop Filter --}}
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

    {{-- Search --}}
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
      <tr>
        <td>
          <a href="{{ route('product.show', $item->product->product_id) }}">
            <img src="{{ Str::startsWith($item->product->image_url, 'products/') 
                ? asset('storage/' . $item->product->image_url) 
                : asset($item->product->image_url) }}" 
                alt="{{ $item->product->product_name }}" 
                class="cart-img">
          </a>
          <div class="product-info">
            <strong>{{ $item->product->product_name }}</strong>

            @if($item->color)
            <div class="item-option">
              Color: 
              <span class="color-badge" style="background:{{ $item->color }}"></span>
              {{ $item->color }}
            </div>
            @endif

            @if($item->size)
            <div class="item-option">
              Size: {{ $item->size }}
            </div>
            @endif
          </div>
        </td>

        {{-- Price --}}
        <td>
          @php
            $price = $item->product->is_on_sale ? $item->product->discount_value : $item->product->price;
          @endphp

          @if($item->product->is_on_sale)
            <span class="sale-price">${{ number_format($price, 2) }}</span>
            <br>
            <small class="old-price">${{ number_format($item->product->price, 2) }}</small>
          @else
            <span class="normal-price">${{ number_format($item->product->price, 2) }}</span>
          @endif
        </td>

        {{-- Quantity + Options --}}
        <td>
         <form action="{{ route('cart.updateQuantity', $item) }}" method="POST" class="update-form horizontal">
    @csrf
    @method('PATCH')

    {{-- Quantity --}}
    <div class="field-group">
        <span class="field-label">Qty</span>
        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
    </div>

    {{-- Color --}}
    @if($item->product->color)
        <div class="field-group">
            <span class="field-label">Color</span>
            <select name="color">
                @foreach(explode(',', $item->product->color) as $color)
                    <option value="{{ trim($color) }}" {{ $item->color == trim($color) ? 'selected' : '' }}>
                        {{ trim($color) }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- Size --}}
    @if($item->product->size)
        <div class="field-group">
            <span class="field-label">Size</span>
            <select name="size">
                @foreach(explode(',', $item->product->size) as $size)
                    <option value="{{ trim($size) }}" {{ $item->size == trim($size) ? 'selected' : '' }}>
                        {{ trim($size) }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    <button type="submit" class="update-btn">Update</button>

</form>

        </td>

        {{-- Total --}}
        <td>${{ number_format($price * $item->quantity, 2) }}</td>

        {{-- Remove --}}
        <td>
          <form action="{{ route('cart.remove', $item) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn-sm danger">Remove</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Cart Summary --}}
  <div class="cart-summary">
    @php
      $cartTotal = $cartItems->sum(function($i) {
          return ($i->product->is_on_sale ? $i->product->discount_value : $i->product->price) * $i->quantity;
      });
    @endphp
    <p><strong>Total: </strong>${{ number_format($cartTotal, 2) }}</p>
    <a href="{{ route('checkout') }}" class="btn checkout-btn">Proceed to Checkout</a>
  </div>

  @else
    <p class="empty-cart-msg">Your cart is empty. Start shopping now!</p>
  @endif

  <style>
    /* ===== Update form horizontal ===== */
.update-form.horizontal {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    flex-wrap: wrap;
}

/* Each field box */
.field-group {
    display: flex;
    flex-direction: column;
    min-width: 70px; /* عرض موحد تقريبا */
}

/* Label above each input/select */
.field-label {
    font-size: 11px;
    font-weight: 600;
    color: #6b511c;
    margin-bottom: 3px;
    text-align: center;
}

/* Quantity input */
.update-form input[type="number"] {
    width: 65px;
    height: 34px;
    padding: 4px 6px;
    text-align: center;
    font-size: 13px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Selects (Color / Size) */
.update-form select {
    width: 100%;
    height: 34px;
    padding: 4px 6px;
    font-size: 13px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Update button aligned */
.update-btn {
    height: 34px;
    background: #ab761b;
    color: #fff;
    padding: 0 14px;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.update-btn:hover {
    background: #533b0b;
}


.color-badge {
    display: inline-block;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 1px solid #ccc;
    vertical-align: middle;
    margin-right: 4px;
}

    body { font-family: 'Segoe UI', Tahoma, sans-serif; background:#f8f9fa; margin:0; padding:0; }
    .content-section { padding:40px 20px; max-width:1100px; margin:0 auto; background:#fff; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.06); }
    h2 { text-align:center; margin-bottom:30px; color:#333; }

    /* Filters */
    .cart-filters { display:flex; flex-wrap:wrap; gap:15px; align-items:flex-end; margin-bottom:25px; }
    .filter-group { display:flex; flex-direction:column; }
    .cart-filters label { font-weight:600; color:#555; margin-bottom:5px; font-size:14px; }
    .cart-filters select, .cart-filters input[type="text"] { padding:8px 12px; border-radius:8px; border:1px solid #ccc; transition:all 0.2s; font-size:14px; }
    .cart-filters select:hover, .cart-filters input[type="text"]:hover { border-color:#ab761b; }
    .apply-btn { background-color:#ab761b; color:#fff; padding:8px 20px; border:none; border-radius:8px; cursor:pointer; font-weight:600; transition:all 0.2s; }
    .apply-btn:hover { background-color:#533b0b; }

    /* Table */
    .cart-table { width:100%; border-collapse:collapse; margin-bottom:30px; }
    .cart-table th, .cart-table td { padding:12px 15px; text-align:left; border-bottom:1px solid #eee; vertical-align:middle; font-size:14px; }
    .cart-table th { background:#f1f1f1; font-weight:600; color:#555; }
    .cart-table tbody tr:hover { background:#f9f9f9; }
    .cart-img { width:60px; height:60px; object-fit:cover; border-radius:8px; margin-right:10px; vertical-align:middle; }
    .product-info { display:inline-block; vertical-align:middle; }
    .item-option { font-size:13px; color:#555; margin-top:3px; }
    .color-badge { display:inline-block; width:14px; height:14px; border-radius:50%; border:1px solid #ccc; vertical-align:middle; margin-right:4px; }

    /* Price */
    .sale-price { color:#E63946; font-weight:700; }
    .old-price { text-decoration:line-through; color:#999; font-size:12px; display:block; }
    .normal-price { color:#1b1b1b; font-weight:600; }

    /* Update form */
    .update-form input[type="number"], .update-form select { margin-bottom:5px; padding:6px 10px; border-radius:6px; border:1px solid #ccc; font-size:14px; }
    .update-btn { background:#ab761b; color:#fff; padding:6px 12px; border:none; border-radius:6px; cursor:pointer; transition:all 0.2s; }
    .update-btn:hover { background:#533b0b; }

    /* Remove button */
    .btn-sm.danger { background:#9c5815; color:#fff; padding:6px 12px; border:none; border-radius:6px; cursor:pointer; transition:all 0.2s; }
    .btn-sm.danger:hover { background:#c0392b; }

    /* Cart summary */
    .cart-summary { text-align:right; font-size:16px; font-weight:600; margin-top:20px; }
    .checkout-btn { display:inline-block; padding:10px 20px; background:#6b511c; color:#fff; border-radius:8px; text-decoration:none; margin-top:10px; transition:all 0.2s; }
    .checkout-btn:hover { background:#533b0b; }

    /* Empty */
    .empty-cart-msg { text-align:center; font-size:16px; color:#777; margin-top:40px; }

    /* Responsive */
    @media(max-width:768px) {
      .cart-filters { flex-direction:column; align-items:flex-start; }
      .cart-table { font-size:13px; }
      .cart-img { width:50px; height:50px; }
    }
    /* Quantity input smaller */
.update-form input[type="number"] {
    width: 65px;          /* صغر العرض */
    height: 34px;         /* صغر الارتفاع */
    padding: 4px 6px;
    text-align: center;
    font-size: 13px;
}

/* Remove arrows (optional – cleaner look) */


  </style>
</section>
@endsection
