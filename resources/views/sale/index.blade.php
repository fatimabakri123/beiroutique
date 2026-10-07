<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --purple-dark: #5b2a86;
            --purple-soft: #1f7bb8eb;
            --blue-soft: #8f3f9beb;
            --bg-light: #fdfcff;
            --white: #ffffff;
            --text-dark: #1e1b4b;
            --text-muted: #6b7280;
            --border-soft: rgba(226,232,240,0.8);
            --shadow-soft: 0 8px 30px rgba(91, 42, 134, 0.08);
            --shadow-medium: 0 15px 40px rgba(91, 42, 134, 0.12);
            --radius-lg: 20px;
            --radius-md: 15px;
            --radius-sm: 10px;
            
            /* Stock colors */
            --stock-low: #ef4444;    /* Red for low stock */
            --stock-medium: #f59e0b; /* Yellow for medium stock */
            --stock-high: #10b981;   /* Green for high stock */
        }

        /* ===== BASE STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* ===== SALE PAGE ===== */
        .sale-page {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* ===== SECTION TITLE ===== */
        .section-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--purple-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 28px;
            background: linear-gradient(135deg, var(--purple-soft), var(--purple-dark));
            border-radius: 4px;
        }

        /* ===== EMPTY TEXT ===== */
        .empty-text {
            color: var(--text-muted);
            font-size: 16px;
            margin-bottom: 40px;
            font-style: italic;
            text-align: center;
            padding: 30px;
            border: 1px dashed var(--border-soft);
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.5);
        }

        /* ===== SHOPS GRID ===== */
        .shops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            margin-bottom: 60px;
        }

        .shop-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 25px 20px;
            text-align: center;
            text-decoration: none;
            color: var(--text-dark);
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-soft);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .shop-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--purple-soft);
        }

        .shop-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--purple-soft), var(--blue-soft));
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }

        .shop-card:hover::after {
            transform: translateX(0);
        }

        .shop-card img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid var(--white);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .shop-card:hover img {
            transform: scale(1.05);
        }

        .shop-card h4 {
            font-size: 17px;
            font-weight: 600;
            margin: 10px 0 5px;
            color: var(--text-dark);
        }

        .shop-location {
            font-size: 14px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .shop-location::before {
            content: '📍';
            font-size: 12px;
        }

        /* ===== PRODUCTS GRID ===== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .product-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-soft);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-medium);
            border-color: var(--purple-soft);
        }

        /* Product Image Container */
        .product-img {
            position: relative;
            width: 100%;
            height: 220px;
            border-radius: var(--radius-md);
            overflow: hidden;
            background: #f8fafc;
            margin-bottom: 20px;
        }

        .product-img a {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-img img {
            transform: scale(1.05);
        }

        /* Image Slider */
        .slider-img {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .slider-img:first-child {
            opacity: 1;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            font-size: 16px;
            color: var(--purple-dark);
            transition: all 0.2s ease;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .slider-btn.prev { left: 10px; }
        .slider-btn.next { right: 10px; }

        .product-img:hover .slider-btn {
            opacity: 1;
            visibility: visible;
        }

        .slider-btn:hover {
            background: var(--white);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        /* Sale Badge */
        .badge-sale {
            position: absolute;
            top: 12px;
            left: 12px;
            background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(91, 42, 134, 0.2);
        }

        /* ===== STOCK INDICATOR ===== */
        .stock-indicator {
            position: absolute;
            bottom: 12px;
            left: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--radius-sm);
            padding: 8px;
            z-index: 10;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .stock-text {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stock-text .label {
            color: var(--text-muted);
        }

        .stock-text .quantity {
            font-weight: 700;
        }

        .stock-bar {
            height: 6px;
            background: rgba(0,0,0,0.1);
            border-radius: 3px;
            overflow: hidden;
            position: relative;
        }

        .stock-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 1s ease;
            position: relative;
        }

        /* Stock level colors */
        .stock-low .stock-fill {
            background: linear-gradient(90deg, var(--stock-low), #f87171);
        }
        
        .stock-medium .stock-fill {
            background: linear-gradient(90deg, var(--stock-medium), #fbbf24);
        }
        
        .stock-high .stock-fill {
            background: linear-gradient(90deg, var(--stock-high), #34d399);
        }

        /* Stock level indicators */
        .stock-low .stock-text .quantity {
            color: var(--stock-low);
            animation: pulse-low 2s infinite;
        }
        
        .stock-medium .stock-text .quantity {
            color: var(--stock-medium);
        }
        
        .stock-high .stock-text .quantity {
            color: var(--stock-high);
        }

        /* Low stock warning animation */
        @keyframes pulse-low {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Stock status label */
        .stock-status {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 8px;
        }

        .stock-low .stock-status {
            background: rgba(239, 68, 68, 0.1);
            color: var(--stock-low);
        }
        
        .stock-medium .stock-status {
            background: rgba(245, 158, 11, 0.1);
            color: var(--stock-medium);
        }
        
        .stock-high .stock-status {
            background: rgba(16, 185, 129, 0.1);
            color: var(--stock-high);
        }

        /* ===== PRODUCT INFO ===== */
        .product-info {
            margin-top: 10px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 8px;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--purple-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Original price if on sale */
        .original-price {
            font-size: 14px;
            color: var(--text-muted);
            text-decoration: line-through;
            font-weight: 500;
        }

        /* Discount percentage */
        .discount-badge {
            background: var(--stock-low);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .product-shop {
            font-size: 13px;
            color: var(--purple-soft);
            font-weight: 500;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(91, 42, 134, 0.08);
            border-radius: var(--radius-sm);
        }

        .product-shop::before {
            content: '🏪';
            font-size: 12px;
        }

        /* Quick View Overlay */
        .product-card::before {
            content: 'View Details';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(91, 42, 134, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            font-size: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: var(--radius-lg);
            z-index: 5;
            cursor: pointer;
            backdrop-filter: blur(2px);
        }

        .product-card:hover::before {
            opacity: 1;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .shops-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 24px;
            }
            
            .shops-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .product-img {
                height: 200px;
            }
        }

        @media (max-width: 480px) {
            .sale-page {
                margin: 20px auto;
                padding: 0 15px;
            }
            
            .shops-grid {
                grid-template-columns: 1fr;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .product-img {
                height: 180px;
            }
            
            .shop-card img {
                width: 80px;
                height: 80px;
            }
            
            .stock-indicator {
                padding: 6px;
            }
        }

        /* ===== ANIMATIONS ===== */
        .shop-card, .product-card {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        /* Simple hover scale effect */
        .shop-card, .product-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Simple loader for images */
        .product-img img, .shop-card img {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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
    </style>
</head>
<body>
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
        <a href="/login"><i class="fa-regular fa-user"></i></a>
        <a href="{{ auth()->check() ? route('customer.wishlist') : route('login') }}">
            <i class="fa-regular fa-heart"></i>
        </a>
        <a href="{{ route('customer.cart') }}" id="cart-icon">
            <i class="fa fa-shopping-bag"></i>
            <span id="cart-count" class="cart-count">{{ $cartCount ?? 0 }}</span>
        </a>
    </div>
</nav>
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
                    <p class="shop-location">{{ $shop->address }}</p>
                </a>
            @empty
                <p class="empty-text">No shops on sale right now.</p>
            @endforelse
        </div>

        {{-- ===== Sale Products ===== --}}
        <h2 class="section-title">💸 Sale Items</h2>

        <div class="products-grid">
            @forelse($saleProducts as $product)
                @php
                    // Calculate stock percentage and determine level
                    $stockQuantity = $product->stock_quantity ?? rand(5, 100);
                    $stockPercentage = min(100, ($stockQuantity / 50) * 100);
                    
                    // Determine stock level
                    if ($stockQuantity <= 10) {
                        $stockLevel = 'low';
                    } elseif ($stockQuantity <= 30) {
                        $stockLevel = 'medium';
                    } else {
                        $stockLevel = 'high';
                    }
                    
                    // Calculate discount percentage if on sale
                    $discountPercentage = 0;
                    if ($product->is_on_sale && $product->price > 0) {
                        $discountPercentage = round((($product->price - ($product->discount_value ?? $product->price)) / $product->price) * 100);
                    }
                @endphp
                
                <div class="product-card">
                    <div class="product-img">
                        <a href="{{ route('product.show', $product->product_id) }}">
                            @php
                                $images = $product->images && $product->images->count()
                                    ? $product->images
                                    : collect([(object)['image_path' => $product->image_url]]);
                            @endphp

                            @foreach($images as $img)
                                <img
                                    src="{{ Str::startsWith($img->image_path, 'products/')
                                        ? asset('storage/' . $img->image_path)
                                        : asset($img->image_path) }}"
                                    class="slider-img"
                                    alt="{{ $product->product_name }}"
                                >
                            @endforeach

                            @if($images->count() > 1)
                                <button class="slider-btn prev">‹</button>
                                <button class="slider-btn next">›</button>
                            @endif
                        </a>
                        <span class="badge-sale">SALE</span>
                        
                        <!-- Stock Indicator -->
                        <div class="stock-indicator stock-{{ $stockLevel }}">
                            <div class="stock-text">
                                <span class="label">Available:</span>
                                <span class="quantity">{{ $stockQuantity }} items</span>
                                <span class="stock-status">
                                    @if($stockLevel == 'low') LOW STOCK
                                    @elseif($stockLevel == 'medium') GOOD
                                    @else IN STOCK
                                    @endif
                                </span>
                            </div>
                            <div class="stock-bar">
                                <div class="stock-fill" style="width: {{ $stockPercentage }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="product-info">
                        <h4 class="product-name">{{ $product->product_name }}</h4>

                        <p class="product-price">
                            ${{ number_format($product->discount_value ?? $product->price, 2) }}
                            @if($product->is_on_sale && $product->price > ($product->discount_value ?? 0))
                                <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                @if($discountPercentage > 0)
                                    <span class="discount-badge">-{{ $discountPercentage }}%</span>
                                @endif
                            @endif
                        </p>

                        <p class="product-shop">
                            {{ $product->shop->shop_name ?? '' }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="empty-text">No sale products available.</p>
            @endforelse
        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple image slider
            document.querySelectorAll('.product-img').forEach(container => {
                const images = container.querySelectorAll('.slider-img');
                const prevBtn = container.querySelector('.prev');
                const nextBtn = container.querySelector('.next');
                
                if (images.length <= 1) return;
                
                let currentIndex = 0;
                
                function showImage(index) {
                    images.forEach((img, i) => {
                        img.style.opacity = i === index ? '1' : '0';
                        img.style.zIndex = i === index ? '1' : '0';
                    });
                    currentIndex = index;
                }
                
                // Next button
                if (nextBtn) {
                    nextBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        let nextIndex = (currentIndex + 1) % images.length;
                        showImage(nextIndex);
                    });
                }
                
                // Previous button
                if (prevBtn) {
                    prevBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        let prevIndex = (currentIndex - 1 + images.length) % images.length;
                        showImage(prevIndex);
                    });
                }
                
                // Auto-slide every 5 seconds
                if (images.length > 1) {
                    setInterval(() => {
                        let nextIndex = (currentIndex + 1) % images.length;
                        showImage(nextIndex);
                    }, 5000);
                }
            });
            
            // Product card click
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Don't trigger if clicking on slider buttons
                    if (e.target.closest('.slider-btn')) {
                        return;
                    }
                    
                    const productLink = this.querySelector('a[href*="product"]');
                    if (productLink) {
                        window.location.href = productLink.href;
                    }
                });
            });
            
            // Remove loading animation when images load
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.style.animation = 'none';
                    this.style.background = 'none';
                });
                
                // Fallback in case image fails to load
                img.addEventListener('error', function() {
                    this.style.animation = 'none';
                    this.style.background = '#f0f0f0';
                });
            });
            
            // Simple hover effect for shop cards
            document.querySelectorAll('.shop-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Animate stock bars on load
            document.querySelectorAll('.stock-fill').forEach(bar => {
                const originalWidth = bar.style.width;
                bar.style.width = '0%';
                
                setTimeout(() => {
                    bar.style.transition = 'width 1.5s ease-in-out';
                    bar.style.width = originalWidth;
                }, 300);
            });
        });
    </script>
</body>
</html>