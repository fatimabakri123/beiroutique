<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Beiroutique | Shop</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* ====== ROOT COLORS & RESET ====== */
:root {
  --primary: #5b21b6; 
  --secondary: #2563eb;
  --accent: #C08A56;   
  --bg: #f8fafc;       
  --card-bg: #ffffff;  
  --text: #1e293b;     
  --muted: #64748b;    
  --border: #e2e8f0;
  --shadow: 0 4px 12px rgba(0,0,0,0.05);
  --radius: 12px;
}

* { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
body { background: var(--bg); color: var(--text); }
a { text-decoration: none; color: inherit; }

/* ====== NAVBAR ====== */
/* ====== FIXED PREMIUM NAVBAR ====== */
.navbar-main {
  position: sticky;
  top: 0;
  z-index: 1000;
  display: grid;
  grid-template-columns: auto 1fr auto; /* back+logo | search | icons */
  align-items: center;
  gap: 30px;
  padding: 14px 40px;
  background: #fff;
  box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

/* logo */
.logo img { width: 220px; }

/* center search */
.vision-search-form {
  max-width: 620px;
  width: 100%;
  justify-self: center;
}

/* right icons */
.nav-icons {
  display: flex;
  align-items: center;
  gap: 22px;
  justify-self: end;
}
.nav-icons a {
  color: #520780;
  font-size: 25px;
  transition: color 0.3s;
}
.nav-icons a:hover { color: var(--primary); }

/* mobile */
@media (max-width: 768px) {
  .navbar-main {
    grid-template-columns: 1fr auto;
    grid-template-rows: auto auto;
    gap: 10px;
  }

  .vision-search-form {
    grid-column: 1 / -1;
    max-width: 100%;
  }

  .logo img { width: 140px; }
}

.cart-count {
  position: absolute;
  top: -8px;
  right: -10px;
  background: var(--accent);
  color: #fff;
  font-size: 10px;
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-weight: bold;
}

/* ====== CATEGORY BAR ====== */
.category-bar {
  background: #fff;
  border-bottom: 1px solid var(--border);
  padding: 10px 5%;
  display: flex;
  justify-content: center;
  gap: 15px;
  overflow-x: auto;
}

.category-bar a {
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 18px;
  font-weight: 500;
  white-space: nowrap;
  color:  #740ab1;
  border: 1px solid var(--border);
  transition: 0.3s;
}

.category-bar a.active, .category-bar a:hover {
  background: linear-gradient(135deg, #a080bc, #5b93c7);
  color: #fff;
  border-color: var(--primary);
}

/* ====== MAIN LAYOUT ====== */
.main-layout {
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 30px;
  padding: 30px 5%;
}

/* ====== COMPACT SIDEBAR ====== */
.sidebar {
  background: #fff;
  padding: 20px;
  border-radius: var(--radius);
  border: 1px solid var(--border);
  height: fit-content;
  position: sticky;
  top: 90px;
}

.sidebar h3 {
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 15px;
  color: #462b8b;
  border-left: 3px solid var(--accent);
  padding-left: 10px;
}

.filter-group {
  margin-bottom: 25px;
}

.filter-grid {
  display: grid;
  grid-template-columns: 1fr 1fr; /* Two columns for compact look */
  gap: 8px;
}

.sidebar label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: var(--muted);
  cursor: pointer;
}

.sidebar input[type="checkbox"] {
  accent-color: var(--primary);
  width: 16px;
  height: 16px;
}

.sidebar select {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: #f8fafc;
  outline: none;
  font-size: 13px;
}

.apply-btn {
  width: 100%;
  background: linear-gradient(135deg, #a080bc, #5b93c7);
  color: #fff;
  padding: 12px;
  border-radius: 8px;
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}

.apply-btn:hover { background: linear-gradient(135deg, #a080bc, #5b93c7); }

/* ====== PRODUCT CARDS ====== */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
}

.product-card {
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  position: relative;
  transition: 0.3s;
  border: 1px solid transparent;
}

.product-card:hover {
  box-shadow: var(--shadow);
  border-color: var(--border);
}

.wishlist-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 5;
  background: rgba(255,255,255,0.8);
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--muted);
  transition: 0.3s;
}

.wishlist-btn:hover { color: #ef4444; background: #fff; }

.product-card img {
  width: 100%;
  height: 280px;
  object-fit: cover;
}

.product-info { padding: 12px; text-align: left; }
.product-info h4 { font-size: 14px; margin-bottom: 5px; font-weight: 500; color: var(--muted); }
.price { font-size: 16px; font-weight: 700; color: var(--text); }
.old-price { text-decoration: line-through; color: #94a3b8; font-size: 13px; margin-left: 5px; }

/* Notifications */
.cart-notification {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: #1e293b;
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    transition: 0.4s;
    z-index: 9999;
}
.cart-notification.show { transform: translateX(-50%) translateY(0); }

@media (max-width: 768px) {
  .main-layout { grid-template-columns: 1fr; }
  .sidebar { position: static; }
  .navbar-main { padding: 10px 15px; }
  .logo img { width: 120px; }
}
.back-btn-wrapper {
    margin-bottom: 40px; 
    display: flex;
    justify-content: flex-start;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
   background: linear-gradient(135deg, #a080bc, #5b93c7);
    color: #fff;
    font-weight: 600;
    font-size: 20px;
    border-radius: 12px;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(124,77,255,0.25);
    transition: all 0.3s ease;
}

.back-btn i {
    font-size: 18px;
}

.back-btn:hover {
    background: linear-gradient(135deg, #a080bc, #5b93c7);
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    color: #fff;
}

/* ===== STATS GRID ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 30px;
    margin-top: 20px;
}
  :root {
    --gold-gradient: linear-gradient(135deg, #a359c5, #1638e2d3);
    --glass: rgba(255, 255, 255, 0.9);
}

.search-glass-wrapper {
    display: flex;
    align-items: center;
    background: var(--glass);
    backdrop-filter: blur(10px);
    border: 1px solid #e0e0e0;
    border-radius: 100px;
    padding: 8px 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.4s ease;
    max-width: 600px;
    margin: 0 auto;
}

.search-glass-wrapper:focus-within {
    border-color: #6e0c9f;
    box-shadow: 0 15px 40px rgba(197, 160, 89, 0.15);
    transform: translateY(-2px);
}

.luxury-input {
    border: none;
    background: none;
    outline: none;
    width: 100%;
    padding: 10px 15px;
    font-size: 16px;
    color: #333;
}

/* Image Preview & Scan Animation */
.search-image-preview {
    display: none;
    position: relative;
    width: 45px;
    height: 45px;
    margin-right: 15px;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid #7e02b7;
}

.search-image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.scan-line {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: #6b1c98b1;
    box-shadow: 0 0 10px #610f86bb;
    animation: scanning 1.5s infinite ease-in-out;
}

@keyframes scanning {
    0% { top: 0; }
    50% { top: 100%; }
    100% { top: 0; }
}

.cancel-image {
    position: absolute;
    top: 0; right: 0;
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    font-size: 12px;
    cursor: pointer;
    border-radius: 0 0 0 8px;
}

/* Icons & Buttons */
.camera-trigger {
    cursor: pointer;
    font-size: 20px;
    color: #888;
    margin-right: 15px;
    transition: color 0.3s;
    position: relative;
}

.camera-trigger:hover { color: #68058bc5; }

.submit-btn {
    background: var(--gold-gradient);
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
}

.submit-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(197, 160, 89, 0.4);
}

.product-slider {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
}

.product-slider img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    display: none;
}

.product-slider img.active {
    display: block;
}

/* Arrows */
.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.85);
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    z-index: 5;
}

.slider-btn.prev { left: 8px; }
.slider-btn.next { right: 8px; }

.slider-btn:hover {
    background: white;
}

</style>
</head>

<body>

<nav class="navbar-main">

  <!-- LEFT -->
  <div style="display:flex;align-items:center;gap:20px;">
    <a href="{{ url()->previous() }}" class="back-btn">
      <i class="fa fa-arrow-left"></i> Back
    </a>

    <div class="logo">
      <a href="/"><img src="{{ asset('image/beiroutique2.png') }}" alt="Logo"></a>
    </div>
  </div>

  <!-- CENTER SEARCH -->
  <form method="POST" action="{{ route('search') }}" 
        class="vision-search-form" id="mainSearchForm" enctype="multipart/form-data">
    @csrf

    <div class="search-glass-wrapper">
      <i class="fa-solid fa-magnifying-glass"></i>

      <input type="search" name="q" id="textSearch"
             class="luxury-input"
             placeholder="Search by text or upload a photo..."
             value="{{ request('q') }}">

      <label for="imageSearch" class="camera-trigger">
        <i class="fa-solid fa-camera"></i>
      </label>
      <input type="file" id="imageSearch" name="image" accept="image/*" hidden>

      <button type="submit" class="submit-btn">Search</button>
    </div>
  </form>

  <!-- RIGHT ICONS -->
  <div class="nav-icons">
    <a href="/login"><i class="fa-regular fa-user"></i></a>

    <a href="{{ auth()->check() ? route('customer.wishlist') : route('login') }}">
      <i class="fa-regular fa-heart"></i>
    </a>

    <a href="{{ route('customer.cart') }}" id="cart-icon">
      <i class="fa fa-shopping-bag"></i>
      
    </a>
  </div>

</nav>

@if(isset($category) && $category->subcategories->count())
<nav class="category-bar">
    @foreach($category->subcategories as $sub)
        <a href="{{ route('subcategory.show', $sub->subcategory_id) }}"
           class="{{ isset($subcategory) && $subcategory->subcategory_id == $sub->subcategory_id ? 'active' : '' }}">
           {{ $sub->subcategory_name }}
        </a>
    @endforeach
</nav>
@endif

<div class="main-layout">
  <aside class="sidebar">
    <form method="GET" action="{{ route('category.show', $category->category_id) }}">
        <div class="filter-group">
            <h3>Sort By</h3>
            <select name="sort">
                <option value="latest">Newest Arrivals</option>
                <option value="price_low_high">Price: Low to High</option>
                <option value="price_high_low">Price: High to Low</option>
            </select>
        </div>

        <div class="filter-group">
            <h3>Price Range</h3>
            <div class="filter-grid">
                <label><input type="checkbox" name="price[]" value="under_50"> < $50</label>
                <label><input type="checkbox" name="price[]" value="50_100"> $50-100</label>
                <label><input type="checkbox" name="price[]" value="100_200"> $100-200</label>
            </div>
        </div>

        <div class="filter-group">
            <h3>Color</h3>
            <div class="filter-grid">
                <label><input type="checkbox" name="color[]" value="Black"> Black</label>
                <label><input type="checkbox" name="color[]" value="White"> White</label>
                <label><input type="checkbox" name="color[]" value="Red"> Red</label>
                <label><input type="checkbox" name="color[]" value="Blue"> Blue</label>
            </div>
        </div>

        <div class="filter-group">
            <h3>Size</h3>
            <div class="filter-grid">
                <label><input type="checkbox" name="size[]" value="S"> S</label>
                <label><input type="checkbox" name="size[]" value="M"> M</label>
                <label><input type="checkbox" name="size[]" value="L"> L</label>
                <label><input type="checkbox" name="size[]" value="XL"> XL</label>
            </div>
        </div>

        <button type="submit" class="apply-btn">Apply Filters</button>
    </form>
  </aside>

  <main class="products-grid">
    @foreach($products as $product) <div class="product-card"> {{-- ❤️ Wishlist Button --}} <form action="{{ route('wishlist.toggle', $product) }}" method="POST" style="display:inline-block;"> @csrf <button type="submit" style="background:none; border:none; cursor:pointer;"> <i class="fa fa-heart"></i> </button> </form>

     <div class="product-slider" data-index="0">
    @php
        $images = $product->images && $product->images->count()
            ? $product->images
            : collect([(object)['image_path' => $product->image_url]]);
    @endphp

    @foreach($images as $img)
        <a href="{{ route('product.show', $product->product_id) }}">
            <img
                src="{{ Str::startsWith($img->image_path, 'products/')
                    ? asset('storage/' . $img->image_path)
                    : asset($img->image_path) }}"
                class="slider-img"
            >
        </a>
    @endforeach

    @if($images->count() > 1)
        <button class="slider-btn prev">‹</button>
        <button class="slider-btn next">›</button>
    @endif
</div>


      <div class="product-info">
        <h4>{{ $product->product_name }}</h4>
        <div class="price">
            @if($product->is_on_sale)
                <span style="color: #ef4444;">${{ number_format($product->discount_value, 2) }}</span>
                <span class="old-price">${{ number_format($product->price, 2) }}</span>
            @else
                ${{ number_format($product->price, 2) }}
            @endif
        </div>
        <div style="font-size: 12px; color: #94a3b8; margin-top: 5px;">
            ⭐ {{ number_format($product->reviews->avg('rating') ?? 0, 1) }} | Stock: {{ $product->stock_quantity }}
        </div>
      </div>
    </div>
    @endforeach
  </main>
</div>

<div id="cart-notification" class="cart-notification">Item added to your bag!</div>

<script>
// Animation logic remains similar but cleaned up
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        // ... (Your existing flying animation & fetch logic)
    });
});

document.querySelectorAll('.product-slider').forEach(slider => {
    const images = slider.querySelectorAll('.slider-img');
    if (images.length === 0) return;

    let index = 0;
    images[index].classList.add('active');

    const prev = slider.querySelector('.prev');
    const next = slider.querySelector('.next');

    function showImage(i) {
        images.forEach(img => img.classList.remove('active'));
        images[i].classList.add('active');
    }

    if (prev) {
        prev.addEventListener('click', e => {
            e.preventDefault();
            index = (index - 1 + images.length) % images.length;
            showImage(index);
        });
    }

    if (next) {
        next.addEventListener('click', e => {
            e.preventDefault();
            index = (index + 1) % images.length;
            showImage(index);
        });
    }
});
</script>

</body>
</html>