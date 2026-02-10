

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<nav class="navbar-main">
    <div class="logo">
        <a href="/"><img src="{{ asset('image/beiroutique2.png') }}" alt="Logo"></a>
    </div>

    <form method="POST" action="{{ route('search') }}" class="vision-search-form" id="mainSearchForm" enctype="multipart/form-data">
        @csrf
        <div class="search-glass-wrapper">
            <div class="search-prefix">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <input type="search" name="q" id="textSearch"
                   class="luxury-input"
                   placeholder="Search by text or upload a photo..."
                   value="{{ request('q') }}">

            <div id="imagePreview" class="search-image-preview">
                <img src="" id="previewImg">
                <button type="button" class="cancel-image" onclick="clearImage()">×</button>
                <div class="scan-line"></div>
            </div>

            <div class="search-suffix">
                <label for="imageSearch" class="camera-trigger" title="Search by Image">
                    <i class="fa-solid fa-camera"></i>
                    <span class="tooltip">Visual Search</span>
                </label>
                <input type="file" id="imageSearch" name="image" accept="image/*" hidden>
                <button type="submit" class="submit-btn">Search</button>
            </div>
        </div>
    </form>

    <div class="nav-icons">
        <a href="/register"><i class="fa-regular fa-user"></i></a>
        <a href="{{ auth()->check() ? route('customer.wishlist') : route('login') }}">
            <i class="fa-regular fa-heart"></i>
        </a>
        <a href="{{ route('customer.cart') }}" id="cart-icon">
            <i class="fa fa-shopping-bag"></i>
            <span id="cart-count" class="cart-count">{{ $cartCount ?? 0 }}</span>
        </a>
    </div>
</nav>

@if($products->count())
<div class="products-grid">
    @foreach($products as $product)
    @php
        $images = $product->images && $product->images->count()
            ? $product->images
            : collect([(object)['image_path' => $product->image_url]]);
    @endphp

    <div class="product-card">
        <div class="product-slider">
            @foreach($images as $img)
                <img src="{{ Str::startsWith($img->image_path, 'products/')
                        ? asset('storage/' . $img->image_path)
                        : asset($img->image_path) }}"
                     class="slider-img">
            @endforeach

            @if($images->count() > 1)
                <button class="slider-btn prev">‹</button>
                <button class="slider-btn next">›</button>
            @endif
        </div>

        @if($product->is_on_sale)
            <span class="badge sale-badge">SALE</span>
        @endif
        @if($product->stock_quantity == 0)
            <span class="badge outstock-badge">OUT OF STOCK</span>
        @endif

        <div class="image-overlay">
            <a href="{{ route('shop.products', $product->shop?->shop_id ?? 0) }}" class="overlay-btn"><i class="fa fa-store"></i></a>
            <a href="{{ route('customer.wishlist', $product->shop?->shop_id ?? 0) }}" class="overlay-btn"><i class="fa fa-heart"></i></a>
        </div>

        <div class="product-info">
            <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
            <h4>{{ $product->product_name }}</h4>

            @if($product->is_on_sale)
                <div class="price">
                    <span>${{ number_format($product->discount_value, 2) }}</span>
                    <br>
                    <small class="original-price">${{ number_format($product->price, 2) }}</small>
                </div>
            @else
                <div class="price">${{ number_format($product->price, 2) }}</div>
            @endif

            <p class="shop-name">{{ $product->shop?->shop_name ?? 'No Shop' }}</p>
        </div>
    </div>
    @endforeach
</div>

<script>
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

@else
<p>No products found.</p>
@endif

<style>
:root {
  --purple-dark: #5b2a86;
  --purple-soft: #1f7bb8eb;
  --blue-soft: #8f3f9beb;
  --bg: #f8fafc;
  --white: #ffffff;
  --text-dark: #1e1b4b;
  --text-muted: #6b7280;
  --border: rgba(226,232,240,0.8);
  --shadow: 0 4px 12px rgba(0,0,0,0.05);
  --radius: 12px;
}

* { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
body { background: var(--bg); color: var(--text-dark); }
a { text-decoration: none; color: inherit; }

/* NAVBAR */
.navbar-main {
    position: sticky;
    top: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    background: var(--white);
    box-shadow: var(--shadow);
    gap: 15px;
}

/* Logo */
.navbar-main .logo img { width: 300px; height: auto; }

/* Search Bar Bigger */
.vision-search-form { flex: 1; display: flex; justify-content: center; position: relative; }
.search-glass-wrapper {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 600px;   /* bigger */
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 50px;
    padding: 10px 25px; /* bigger */
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}
.search-glass-wrapper:focus-within { border-color: var(--purple-dark); box-shadow: 0 0 0 3px rgba(91,42,134,0.1); }

.luxury-input { flex: 1; border: none; outline: none; background: transparent; font-size: 16px; padding: 10px 12px; }
.search-prefix i { font-size: 22px; margin-right: 10px; color: var(--purple-soft); }

/* Image preview bigger */
.search-image-preview { display: none; position: relative; width: 50px; height: 50px; margin-right: 10px; border-radius: 10px; overflow: hidden; border: 2px solid var(--purple-dark); }
.search-image-preview img { width: 100%; height: 100%; object-fit: cover; }
.scan-line { position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: var(--purple-soft); animation: scanning 1.5s infinite ease-in-out; }
@keyframes scanning { 0% { top:0; } 50%{ top:100%; } 100%{ top:0; } }
.cancel-image { position: absolute; top:0; right:0; background: rgba(0,0,0,0.5); color:white; border:none; font-size:12px; cursor:pointer; border-radius:0 0 0 8px; }

/* Suffix buttons bigger */
.search-suffix { display:flex; align-items:center; gap:8px; }
.camera-trigger { cursor:pointer; font-size:20px; color: var(--purple-soft); }
.camera-trigger:hover { color: var(--purple-dark); }
.submit-btn { padding: 10px 20px; font-size: 15px; background: linear-gradient(135deg, var(--purple-dark), var(--blue-soft)); color:#fff; border:none; border-radius:50px; font-weight:600; cursor:pointer; transition: all 0.3s ease; }
.submit-btn:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(91,42,134,0.3); }

/* Nav icons */
.nav-icons { display:flex; align-items:center; gap:30px; }
.nav-icons a { font-size:25px; color: var(--purple-dark); position: relative; transition:0.3s; }
.nav-icons a:hover { color: var(--blue-soft); }
.cart-count { position:absolute; top:-6px; right:-8px; background: var(--purple-soft); color:#fff; font-size:10px; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; }

/* Products Grid */
.products-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(230px,1fr)); gap:25px; margin:20px; }

/* Product Card */
.product-card { position:relative; background:var(--white); border-radius:var(--radius); overflow:hidden; border:1px solid var(--border); text-align:center; transition: transform 0.4s ease, box-shadow 0.4s ease; cursor:pointer; }
.product-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 10px 30px rgba(91,42,134,0.18); }

/* Badges */
.badge { position:absolute; top:10px; left:10px; padding:5px 8px; font-size:12px; font-weight:bold; border-radius:5px; color:#fff; z-index:5; }
.sale-badge { background: var(--purple-soft); }
.outstock-badge { background: #e74c3c; }

/* Product Slider */
.product-slider { position:relative; width:100%; height:260px; overflow:hidden; }
.slider-img { width:100%; height:100%; object-fit:cover; display:none; transition: transform 0.5s ease; }
.slider-img.active { display:block; }
.product-card:hover .slider-img.active { transform: scale(1.05); }

/* Slider Buttons */
.slider-btn { position:absolute; top:50%; transform: translateY(-50%); background: rgba(255,255,255,0.9); border:none; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:18px; color: var(--purple-dark); display:flex; align-items:center; justify-content:center; z-index:10; transition: transform 0.3s ease, background 0.3s ease; }
.slider-btn:hover { background:#fff; transform: scale(1.1); }
.slider-btn.prev { left:-10px; }
.slider-btn.next { right:-10px; }

/* Image Overlay */
.image-overlay { position:absolute; bottom:10px; left:50%; transform:translateX(-50%); display:flex; gap:10px; background:rgba(255,255,255,0.85); padding:5px 12px; border-radius:25px; opacity:0; pointer-events:none; transition: opacity 0.3s ease, transform 0.3s ease; z-index:15; }
.product-card:hover .image-overlay { opacity:1; pointer-events:auto; transform: translateX(-50%) translateY(-5px); }
.overlay-btn { background: var(--purple-soft); color:#fff; border-radius:50%; width:35px; height:35px; display:flex; align-items:center; justify-content:center; font-size:16px; cursor:pointer; transition: transform 0.3s ease, background 0.3s ease; }
.overlay-btn:hover { transform:scale(1.1); background: var(--purple-dark); }
.overlay-btn.wishlist-btn { background: var(--blue-soft); }
.overlay-btn.wishlist-btn:hover { background: var(--purple-soft); }

/* Product Info */
.product-info { padding:15px; }
.product-info h4 { font-size:16px; margin:5px 0; }
.product-info p { font-size:13px; color:var(--text-muted); margin-bottom:5px; }
.price { font-weight:bold; font-size:16px; color: var(--purple-dark); }
.price span { color: var(--purple-soft); }
.original-price { text-decoration:line-through; font-size:13px; color:#999; }
.shop-name { font-size:13px; color: var(--blue-soft); }

/* Responsive */
@media(max-width:900px){
    .products-grid { grid-template-columns: repeat(auto-fill, minmax(180px,1fr)); gap:15px; }
    .product-slider { height:200px; }
    .image-overlay { gap:5px; }
    .overlay-btn { width:30px; height:30px; font-size:14px; }
    .navbar-main { flex-wrap:wrap; gap:10px; }
    .logo img { width:150px; }
    .search-glass-wrapper { max-width:100%; }
}
</style>

