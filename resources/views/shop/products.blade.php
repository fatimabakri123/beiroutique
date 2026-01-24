<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->shop_name }}</title>
</head>
<body>

<div class="container">

    <!-- ===== Shop Card ===== -->
     <!-- ===== HERO SECTION ===== -->
<div class="hero">
    <div class="hero-content">
        <h1>
            Welcome to <span>{{ $shop->shop_name }}</span>
        </h1>

        <p class="hero-subtitle">
            Discover unique products crafted just for you ✨
        </p>

        <div class="offer-box">
            <h3>Our Shop Offers</h3>
            <p>
                {{ $shop->description ?? 'High quality products, amazing prices, and a shopping experience you will love.' }}
            </p>
        </div>

       <button class="view-btn" onclick="toggleProducts()">
            Explore Products
        </button>
    </div>
</div>

  

    <!-- ===== Products (HIDDEN INITIALLY) ===== -->
    <div id="productsSection" class="products-wrapper">
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                  <a href="{{ route('product.show', $product->product_id) }}">
  <img src="{{ Str::startsWith($product->image_url, 'products/') ? asset('storage/' . $product->image_url) : asset($product->image_url) }}" alt="{{ $product->product_name }}">
  </a>
                    <h4>{{ $product->product_name }}</h4>
                    @if($product->is_on_sale)
        <div class="price">
            <span style="color:red; font-weight:bold;">
                ${{ number_format($product->discount_value, 2) }}
            </span>
            <br>
            <small style="text-decoration: line-through; color:#999;">
                ${{ number_format($product->price, 2) }}
            </small>
        </div>
    @else
        <div class="price">
            ${{ number_format($product->price, 2) }}
        </div>
    @endif
                  
                </div>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

</div>

<!-- ===== JS ===== -->
<script>
function toggleProducts() {
    const section = document.getElementById('productsSection');
    section.classList.toggle('show');
}
</script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(180deg, #FAF7F3, #EDE6DB);
    color: #7F5539;
}

/* ===== CONTAINER ===== */
.container {
    max-width: 1200px;
    margin: auto;
    padding: 40px 30px;
}

/* ===== HERO ===== */
.hero {
    background: linear-gradient(135deg, #EDE6DB, #FAF7F3);
    padding: 90px 50px;
    border-radius: 28px;
    margin-bottom: 70px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 45px rgba(0,0,0,0.08);
}

.hero::before,
.hero::after {
    content: "";
    position: absolute;
    width: 260px;
    height: 260px;
    background: radial-gradient(circle, #DDB892, transparent 70%);
    opacity: 0.35;
    border-radius: 50%;
}

.hero::before {
    top: -120px;
    right: -90px;
}

.hero::after {
    bottom: -120px;
    left: -90px;
}

.hero-content {
    max-width: 720px;
    animation: fadeUp 1s ease;
}

.hero h1 {
    font-size: 46px;
    margin-bottom: 18px;
    font-weight: 600;
}

.hero h1 span {
    color: #B08968;
}

.hero-subtitle {
    font-size: 18px;
    color: #8B6B4F;
    margin-bottom: 28px;
}

.offer-box {
    background: rgba(255,255,255,0.6);
    padding: 26px;
    border-radius: 18px;
    margin-bottom: 35px;
    box-shadow: inset 0 0 0 1px rgba(176,137,104,0.25);
}

.offer-box h3 {
    margin-bottom: 10px;
    color: #7F5539;
    font-size: 20px;
}

.offer-box p {
    line-height: 1.7;
}

/* ===== BUTTON ===== */
.view-btn {
    padding: 15px 36px;
    background: linear-gradient(135deg, #B08968, #7F5539);
    color: #fff;
    border-radius: 40px;
    border: none;
    font-weight: 500;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.35s ease;
}

.view-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 35px rgba(127,85,57,0.35);
}

/* ===== PRODUCTS ===== */
.products-wrapper {
    display: none;
}

.products-wrapper.show {
    display: block;
    animation: fadeUp 0.6s ease;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 28px;
}

/* ===== PRODUCT CARD ===== */
.product-card {
    background: #fff;
    padding: 20px;
    border-radius: 22px;
    text-align: center;
    box-shadow: 0 12px 30px rgba(0,0,0,0.07);
    transition: all 0.35s ease;
}

.product-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 22px 40px rgba(0,0,0,0.12);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 16px;
    margin-bottom: 14px;
}

.product-card h4 {
    font-size: 16px;
    margin-bottom: 6px;
}

.product-card p {
    font-weight: 600;
    color: #B08968;
}

/* ===== PAGINATION ===== */
.pagination {
    margin-top: 45px;
    justify-content: center;
}

.page-link {
    border-radius: 12px;
    margin: 0 4px;
    color: #7F5539;
    border: 1px solid #DDB892;
}

.page-item.active .page-link {
    background: #B08968;
    border-color: #B08968;
    color: #fff;
}

/* ===== ANIMATION ===== */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>

</body>
</html>
