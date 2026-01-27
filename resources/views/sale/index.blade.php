<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="sale-page">

  {{-- ===== Shops on Sale ===== --}}
  <h2 class="section-title">🔥 Shops on Sale</h2>

  <div class="shops-grid">
    @forelse($shopsOnSale as $shop)
      <a href="{{ route('shop.products', $shop->shop_id) }}" class="shop-card">
        <img
          src="{{ $shop->logo_url
                ? asset('storage/'.$shop->logo_url)
                : asset('images/default-shop.png') }}"
          alt="{{ $shop->shop_name }}"
        >
        <h4>{{ $shop->shop_name }}</h4>
        <p class="shop-location">{{ $shop->location }}</p>
      </a>
    @empty
      <p class="empty-text">No shops on sale right now.</p>
    @endforelse
  </div>

  {{-- ===== Sale Products ===== --}}
  <h2 class="section-title">💸 Sale Items</h2>

  <div class="products-grid">
    @forelse($saleProducts as $product)
      <div class="product-card">

        <div class="product-img">
          <img
            src="{{ $product->image_url
                  ? asset('storage/'.$product->image_url)
                  : asset('images/default-product.png') }}"
            alt="{{ $product->product_name }}"
          >
          <span class="badge-sale">SALE</span>
        </div>

        <h4 class="product-name">{{ $product->product_name }}</h4>

        <p class="product-price">
          ${{ number_format($product->price, 2) }}
        </p>

        <p class="product-shop">
          {{ $product->shop->shop_name ?? '' }}
        </p>

      </div>
    @empty
      <p class="empty-text">No sale products available.</p>
    @endforelse
  </div>

</section>
<style>
    /* ===== Sale Page Wrapper ===== */
.sale-page {
  max-width: 1200px;
  margin: 60px auto;
  padding: 0 20px;
  font-family: 'Segoe UI', Tahoma, sans-serif;
}

/* ===== Section Title ===== */
.section-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 25px;
  color: #111;
}

/* ===== Empty Text ===== */
.empty-text {
  color: #777;
  font-size: 15px;
  margin-bottom: 40px;
}

/* =========================
   Shops on Sale
========================= */
.shops-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 25px;
  margin-bottom: 70px;
}

.shop-card {
  background: #fff;
  border-radius: 14px;
  padding: 18px;
  text-align: center;
  text-decoration: none;
  color: #111;
  box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.shop-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 14px 30px rgba(0, 0, 0, 0.1);
}

.shop-card img {
  width: 90px;
  height: 90px;
  object-fit: contain;
  border-radius: 50%;
  margin-bottom: 12px;
}

.shop-card h4 {
  font-size: 16px;
  font-weight: 600;
  margin: 6px 0;
}

.shop-location {
  font-size: 13px;
  color: #777;
}

/* =========================
   Sale Products
========================= */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
  gap: 30px;
}

.product-card {
  background: #fff;
  border-radius: 18px;
  padding: 16px;
  box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.product-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 14px 30px rgba(0, 0, 0, 0.1);
}

/* Product Image */
.product-img {
  position: relative;
  width: 100%;
  height: 220px;
  border-radius: 14px;
  overflow: hidden;
  background: #f6f6f6;
}

.product-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* SALE Badge */
.badge-sale {
  position: absolute;
  top: 12px;
  left: 12px;
  background: #e60023;
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  padding: 6px 12px;
  border-radius: 20px;
}

/* Product Info */
.product-name {
  font-size: 16px;
  font-weight: 600;
  margin: 14px 0 6px;
  color: #111;
}

.product-price {
  font-size: 15px;
  font-weight: 700;
  color: #e60023;
}

.product-shop {
  font-size: 13px;
  color: #777;
  margin-top: 4px;
}

/* =========================
   Responsive
========================= */
@media (max-width: 768px) {
  .section-title {
    font-size: 22px;
  }

  .product-img {
    height: 180px;
  }
}

@media (max-width: 480px) {
  .sale-page {
    margin: 30px auto;
  }

  .products-grid {
    grid-template-columns: 1fr;
  }

  .shops-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>

</body>
</html>



