<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Shein-style Product Grid</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* ===== General ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  color: #3e2a1f;
  background: #fff;
}

/* ===== Navbar ===== */
.navbar-main {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 40px;
  position: sticky;
  top: 0;
  background: #fff;
  box-shadow: 0 3px 20px rgba(0,0,0,0.08);
  z-index: 100;
}

.navbar-main .logo img {
  width: 270px;
  transition: transform 0.3s;
}

.navbar-main .logo img:hover {
  transform: scale(1.05);
}

.search-container {
  flex: 1;
  display: flex;
  margin: 0 20px;
}

.search-container input[type="search"] {
  flex: 1;
  padding: 10px 15px;
  border: 1px solid #C08A56;
  border-radius: 25px 0 0 25px;
  outline: none;
}

.search-container button {
  padding: 10px 20px;
  border: none;
  background: linear-gradient(135deg, #C08A56, #8B5E3C);
  border-radius: 0 25px 25px 0;
  cursor: pointer;
  color: #fff;
}

/* ===== Category Bar ===== */
.category-bar {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  background: #fff7f0;
  padding: 15px;
  gap: 15px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.category-bar li a {
  padding: 12px 20px;
  font-size: 15px;
  background: #fff;
  color: #C08A56;
  border-radius: 25px;
  text-decoration: none;
  border: 1px solid #f0e6de;
  font-weight: 500;
  transition: all 0.3s;
}

.category-bar li a:hover {
  background: #C08A56;
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* ===== Layout ===== */
.main-layout {
  display: flex;
  gap: 25px;
  margin: 25px 40px;
  align-items: flex-start;
  flex-wrap: wrap; 
}

/* ===== Sidebar ===== */
/* ===== Sidebar ===== */
.sidebar {
  width: 320px;
  padding: 25px;
  background: #fff;
  border-radius: 15px;
  border: 1px solid #eee;
  box-shadow: 0 6px 20px rgba(0,0,0,0.05);
  position: sticky;      /* make it fixed while scrolling */
  top: 20px;             /* distance from top */
  align-self: start;     /* important inside flex container */
  height: fit-content;   /* adjust height to content */
}

/* ===== Responsive ===== */
@media(max-width:900px){
  .main-layout {
    flex-direction: column;
  }
  .sidebar {
    width: 100%;
    position: relative;   /* remove sticky on mobile */
    top: 0;
    margin-bottom: 20px;
  }
}


.sidebar h3 {
  margin-bottom: 15px;
  color: #C08A56;
  font-size: 18px;
  font-weight: 600;
}

.sidebar label {
  display: block;
  font-size: 14px;
  margin-bottom: 12px;
  color: #555;
  padding-left: 30px;
  position: relative;
  cursor: pointer;
  transition: all 0.3s;
}

.sidebar label input {
  position: absolute;
  left: 0;
  top: 2px;
  width: 22px;
  height: 22px;
  accent-color: #C08A56;
}

.sidebar label:hover {
  color: #C08A56;
  font-weight: 500;
}

/* ===== Products Grid ===== */
.products-grid {
  flex: 1;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
  gap: 25px;
}

/* Product Card */
.product-card {
  background: #fff;
  border-radius: 15px;
  overflow: hidden;
  border: 1px solid #eee;
  text-align: center;
  transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.product-card img {
  width: 100%;
  height: 260px;
  object-fit: cover;
}

.product-info {
  padding: 12px;
}

.product-info h4 {
  font-size: 15px;
  margin-bottom: 6px;
  color: #3e2a1f;
}

.product-info .price {
  font-weight: bold;
  color: #C08A56;
}

.quick-btn {
  display: inline-block;
  text-align: center;
  background: #C08A56;
  color: #fff;
  padding: 12px 0;
  margin-top: 10px;
  text-decoration: none;
  border-radius: 8px;
  padding: 10px 15px;
  width: 80%;
  font-weight: bold;
  transition: background 0.3s, transform 0.2s;
}

.quick-btn:hover {
  background: #8B5E3C;
  transform: scale(1.05);
}

/* ===== Responsive ===== */
@media(max-width:900px){
  .main-layout {
    flex-direction: column;
  }
  .sidebar {
    width: 100%;
    margin-bottom: 20px;
  }
}
.filter-section {
  margin-bottom: 20px;
  display: block;

}
.navbar-main .nav-icons a {
  margin-left: 20px;
  color: #87370dff;
  font-size: 20px;
  text-decoration: none;
}
</style>


</head>

<body>

<!-- Navbar -->
<nav class="navbar-main">
  <div class="logo">
    <img src="{{ asset('image/beiroutique2.png') }}" alt="Logo">
  </div>
  <form class="search-container" action="{{ url('/search') }}" method="GET">
    <input type="search" name="q" placeholder="Search for products, brands and more..." />
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  <div class="nav-icons">
    <a href="/register"><i class="fa-regular fa-user"></i></a>
    <a href="{{ auth()->check() ? route('customer.wishlist') : route('login') }}">
    <i class="fa fa-heart"></i>
    </a>

    <a href="{{ route('customer.cart') }}" id="cart-icon" style="position: relative;">
    <i class="fa fa-shopping-cart"></i>
    <span id="cart-count" class="cart-count">{{ $cartCount ?? 0 }}</span>
   </a>

  </div>
</nav>


<!-- Category / Subcategory Bar -->
@if(isset($category) && $category->subcategories->count())
<nav class="category-bar">
    <ul>
        @foreach($category->subcategories as $sub)
        <li>
            <a href="{{ route('subcategory.show', $sub->subcategory_id) }}"
   class="{{ isset($subcategory) && $subcategory->subcategory_id == $sub->subcategory_id ? 'active' : '' }}">
   {{ $sub->subcategory_name }}
</a>

        </li>
        @endforeach
    </ul>
</nav>
@endif


<!-- Toggle for Mobile -->
<button class="toggle-sidebar" onclick="document.querySelector('.sidebar').classList.toggle('open')">
</button>

<!-- Main Layout -->
<div class="main-layout">
  <!-- Sidebar -->
 <div class="sidebar">
    <form method="GET" action="{{ route('category.show', $category->category_id) }}">

        <div class="sort-section">
            <h3>Sort By</h3>
            <select name="sort">
                <option value="latest">Newest</option>
                <option value="price_low_high">Price: Low to High</option>
                <option value="price_high_low">Price: High to Low</option>
                <option value="popular">Most Popular</option>
            </select>
        </div>

        <div class="filter-section">
            <h3>Price Range</h3>
            <label><input type="checkbox" name="price[]" value="under_50"> Under $50</label>
            <label><input type="checkbox" name="price[]" value="50_100"> $50 - $100</label>
            <label><input type="checkbox" name="price[]" value="100_200"> $100 - $200</label>
        </div>

        <div class="filter-section">
            <h3>Color</h3>
            <label><input type="checkbox" name="color[]" value="Black"> Black</label>
            <label><input type="checkbox" name="color[]" value="White"> White</label>
            <label><input type="checkbox" name="color[]" value="Brown"> Brown</label>
            <label><input type="checkbox" name="color[]" value="Red"> Red</label>
        </div>

        <div class="filter-section">
            <h3>Size</h3>
            <label><input type="checkbox" name="size[]" value="S"> S</label>
            <label><input type="checkbox" name="size[]" value="M"> M</label>
            <label><input type="checkbox" name="size[]" value="L"> L</label>
            <label><input type="checkbox" name="size[]" value="XL"> XL</label>
        </div>

        <button type="submit"  class="quick-btn" style="margin-top:10px;">Apply Filters</button>
    </form>
</div>

  <!-- Products Grid -->
<div class="products-grid">
@foreach($products as $product)
    <div class="product-card">
      {{-- ❤️ Wishlist Button --}}
  <form action="{{ route('wishlist.toggle', $product) }}" method="POST" style="display:inline-block;">
      @csrf
      <button type="submit" style="background:none; border:none; cursor:pointer;">
          <i class="fa fa-heart"></i>
      </button>
  </form>

        <a href="{{ route('product.show', $product->product_id) }}">
            <img src="{{ Str::startsWith($product->image_url, 'products/') 
                ? asset('storage/' . $product->image_url) 
                : asset($product->image_url) }}">
        </a>

        <div class="product-info">
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

    <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
    <p>⭐ {{ number_format($product->reviews->avg('rating') ?? 0, 1) }}</p>
</div>


    </div>
@endforeach
</div>


<style>

  .category-bar li a.active {
    background-color: #C08A56; /* brown/orange theme */
    color: #fff;               /* white text */
}

  .product-card {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  text-align: center;
  border: 1px solid #eee;
  transition: 0.3s;
  text-decoration: none;
  color: inherit;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.product-card img {
  width: 100%;
  height: 260px;
  object-fit: cover;
}

.product-info {
  padding: 10px;
  font-size: 14px;
}

  .cart-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border-radius: 5px;
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.4s ease;
    z-index: 9999;
}
.cart-notification.show {
    opacity: 1;
    transform: translateY(0);
}
/* Cart Bounce Animation */
@keyframes cart-bounce {
  0% { transform: scale(1); }
  30% { transform: scale(1.3); }
  60% { transform: scale(0.9); }
  100% { transform: scale(1); }
}
.cart-count {
    position: absolute;
    top: -8px;
    right: -10px;
    background: #C08A56;
    color: white;
    font-size: 12px;
    padding: 3px 7px;
    border-radius: 50%;
    font-weight: bold;
}

#cart-icon.animate {
  animation: cart-bounce 0.6s ease;
}

</style>


<div id="cart-notification" class="cart-notification">Added to cart!</div>
<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        /* === 1) Flying image animation === */
        const productCard = this.closest('.product-card');
        const productImage = productCard.querySelector('img');

        const flying = productImage.cloneNode(true);
        flying.style.position = "fixed";
        flying.style.zIndex = "9999";
        flying.style.width = productImage.offsetWidth + "px";
        flying.style.height = productImage.offsetHeight + "px";

        const rect = productImage.getBoundingClientRect();
        flying.style.top = rect.top + "px";
        flying.style.left = rect.left + "px";

        document.body.appendChild(flying);

        const cart = document.getElementById("cart-icon").getBoundingClientRect();

        flying.animate([
            { transform: "translate(0,0) scale(1)", opacity: 1 },
            { transform: `translate(${cart.left - rect.left}px, ${cart.top - rect.top}px) scale(0.1)`, opacity: 0.3 }
        ], {
            duration: 700,
            easing: "ease-in-out"
        });

        setTimeout(() => flying.remove(), 700);

        /* === 2) Send request WITHOUT JSON === */
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': formData.get('_token') }
        })
        .then(() => {

            /* === 3) Increase cart counter === */
            const countSpan = document.getElementById('cart-count');
            let count = parseInt(countSpan.innerText);
            countSpan.innerText = count + 1; 
            /* === 4) Cart bounce animation === */
            const cartIcon = document.getElementById('cart-icon');
            cartIcon.classList.add('animate');
            setTimeout(() => cartIcon.classList.remove('animate'), 600);

            /* === 5) Notification === */
            const notification = document.getElementById('cart-notification');
            notification.classList.add('show');
            setTimeout(() => notification.classList.remove('show'), 2000);
        });
        
    });
    
});

</script>
</body>
</html>