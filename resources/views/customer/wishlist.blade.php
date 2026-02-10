@extends('layouts.customer')

@section('content')
<section id="wishlist" class="content-section active wishlist-page">

  <!-- Back Button -->
  <div class="back-btn-wrapper">
    <a href="{{ url()->previous() }}" class="back-btn">
      <i class="fa fa-arrow-left"></i> Back
    </a>
  </div>

  <h2 class="wishlist-title">💜 My Wishlist</h2>

  @if($wishlist && $wishlist->items->count() > 0)
    <div class="wishlist-grid">
      @foreach($wishlist->items as $item)
        <div class="wishlist-card">

          <a href="{{ route('product.show', $item->product->product_id) }}">
            <img src="{{ Str::startsWith($item->product->image_url, 'products/')
              ? asset('storage/' . $item->product->image_url)
              : asset($item->product->image_url) }}"
              alt="{{ $item->product->product_name }}" class="wishlist-img">
          </a>

          <h4>{{ $item->product->product_name }}</h4>

          @if($item->product->is_on_sale)
            <span class="sale-price">${{ number_format($item->product->discount_value, 2) }}</span><br>
            <small class="old-price">${{ number_format($item->product->price, 2) }}</small>
          @else
            <span class="normal-price">${{ number_format($item->product->price, 2) }}</span>
          @endif

          <div class="wishlist-actions">
            <form action="{{ route('cart.add', $item->product) }}" method="POST">
              @csrf
              <button type="submit" class="quick-btn">Add to Cart</button>
            </form>

            <form action="{{ route('wishlist.destroy', $item->wishlist_item_id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-sm danger">Remove</button>
            </form>
          </div>

        </div>
      @endforeach
    </div>
  @else
    <p class="no-wishlist">Your wishlist is empty. Save products you love 💕</p>
  @endif

</section>

<style>
/* ===== PAGE CARD ===== */
.wishlist-page {
  background: linear-gradient(135deg, #fdfcff, #f6f0ff);
  padding: 20px 40px 35px;
  border-radius: 24px;
  box-shadow: inset 0 0 0 1px rgba(124,77,255,0.08);
  min-height: 100vh;
}

/* ===== BACK BUTTON ===== */
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

/* ===== TITLE ===== */
.wishlist-title {
  text-align: center;
  font-size: 28px;
  margin: 10px 0 30px;
  color: var(--purple-dark);
  font-weight: 600;
}

/* ===== GRID ===== */
.wishlist-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 24px;
}

/* ===== CARD ===== */
.wishlist-card {
  background: #fff;
  border-radius: 18px;
  padding: 16px;
  width: 220px;
  text-align: center;
  box-shadow: 0 16px 35px rgba(124,77,255,0.15);
  transition: all 0.3s ease;
}

.wishlist-card:hover {
  transform: translateY(-6px) scale(1.03);
  box-shadow: 0 22px 45px rgba(124,77,255,0.25);
}

.wishlist-card h4 {
  font-size: 15px;
  margin: 10px 0 6px;
  color: var(--purple-dark);
}

/* ===== IMAGE ===== */
.wishlist-img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 12px;
}

/* ===== PRICES ===== */
.sale-price { color: #7b2fae; font-weight: 700; }
.old-price { font-size: 12px; color: #aaa; text-decoration: line-through; }
.normal-price { color: #333; font-weight: 600; }

/* ===== ACTIONS ===== */
.wishlist-actions {
  margin-top: 10px;
  display: flex;
  gap: 8px;
  justify-content: center;
}

.quick-btn {
   background: linear-gradient(135deg, #a080bc, #5b93c7);
  color: #fff;
  border: none;
  padding: 8px 14px;
  border-radius: 999px;
  cursor: pointer;
  font-size: 12px;
  transition: 0.25s ease;
}

.quick-btn:hover { transform: translateY(-2px); }

.btn-sm.danger {
  background: #ef4444;
  color: #fff;
  border: none;
  padding: 8px 14px;
  border-radius: 999px;
  cursor: pointer;
  font-size: 12px;
}

.no-wishlist {
  text-align: center;
  color: #999;
  margin-top: 30px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px) {
  .wishlist-grid {
    justify-content: center;
  }

  .wishlist-card {
    width: 100%;
    max-width: 280px;
  }
}
</style>
@endsection
