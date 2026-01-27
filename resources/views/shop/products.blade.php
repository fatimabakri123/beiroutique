<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->shop_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Cormorant+Garamond:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
</head>
<body>

<div class="bg-blobs">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
</div>

<div class="container">
    <section class="hero-section reveal">
        <div class="hero-content">
            
            <h1 class="shop-title">Welcome to <span>{{ $shop->shop_name }}</span>  Shop</h1>
            <p class="hero-description">
              In our store We offer : 
                {{ $shop->description ?? 'Discover a world of curated elegance and premium quality products designed for your lifestyle.' }}
            </p>

            <div class="contact-bar">
                <div class="info-pill">
                    <span class="pill-icon">📍</span>
                    <span>{{ $shop->address }}</span>
                </div>
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $shop->contact_phone) }}" target="_blank" class="whatsapp-luxury">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WA">
                    <span>Chat With Us</span>
                </a>
            </div>

            <button class="main-cta" onclick="toggleProducts()">
                Explore The Collection
                <div class="btn-shine"></div>
            </button>
        </div>
    </section>

    <div id="productsSection" class="products-wrapper">
        <div class="section-title">
            <span class="line"></span>
            <h2>Our Selection</h2>
            <span class="line"></span>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card reveal">
                    <div class="image-box">
                        <a href="{{ route('product.show', $product->product_id) }}">
                            <img src="{{ Str::startsWith($product->image_url, 'products/') ? asset('storage/' . $product->image_url) : asset($product->image_url) }}" alt="{{ $product->product_name }}">
                        </a>
                        @if($product->is_on_sale)
                            <div class="sale-tag">Limited Offer</div>
                        @endif
                    </div>
                    
                    <div class="product-details">
    <h4>{{ $product->product_name }}</h4>
    <div class="price-box">
        @if($product->is_on_sale)
            <span class="new-price">${{ number_format($product->discount_value, 2) }}</span>
            <span class="old-price">${{ number_format($product->price, 2) }}</span>
        @else
            <span class="regular-price">${{ number_format($product->price, 2) }}</span>
        @endif
    </div>
    
    <a href="{{ route('product.show', $product->product_id) }}" class="view-item-btn">
        View Details
    </a>
</div>
                </div>
            @empty
                <div class="empty-state">Currently refreshing our stock for you.</div>
            @endforelse
        </div>
        
        <div class="pagination-area">
            {{ $products->links() }}
        </div>
    </div>
</div>

<style>
:root {
    --brand: #C5A059; /* Modern Gold */
    --text-dark: #2D241E;
    --text-light: #756E66;
    --bg-main: #FFFFFF;
    --bg-soft: #F9F7F5;
    --glass: rgba(255, 255, 255, 0.7);
}

* { box-sizing: border-box; transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1); }

body {
    background-color: var(--bg-soft);
    color: var(--text-dark);
    font-family: 'Plus Jakarta Sans', sans-serif;
    margin: 0;
    overflow-x: hidden;
}

/* Background Animation */
.bg-blobs {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
    overflow: hidden; background: #fff;
}
.blob {
    position: absolute; width: 600px; height: 600px; border-radius: 50%;
    filter: blur(80px); opacity: 0.4;
}
.blob-1 { background: #E8D5C4; top: -10%; right: -5%; animation: float 10s infinite alternate; }
.blob-2 { background: #D4E2D4; bottom: -10%; left: -5%; animation: float 12s infinite alternate-reverse; }

@keyframes float { 0% { transform: translate(0,0); } 100% { transform: translate(40px, 60px); } }

.container { max-width: 1200px; margin: auto; padding: 40px 20px; }

/* ===== HERO STYLE ===== */
.hero-section {
    background: var(--glass);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: 40px;
    padding: 100px 40px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    margin-bottom: 60px;
}

.top-badge {
    font-size: 12px; letter-spacing: 3px; color: var(--brand); font-weight: 700; margin-bottom: 20px;
}

.shop-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(45px, 8vw, 85px);
    margin: 0 0 25px 0;
    line-height: 1;
}

.shop-title span { color: var(--brand); font-style: italic; }

.hero-description {
    font-size: 18px; color: var(--text-light); max-width: 650px; margin: 0 auto 40px; line-height: 1.7;
}

/* Contact Bar */
.contact-bar {
    display: flex; justify-content: center; gap: 15px; margin-bottom: 45px; flex-wrap: wrap;
}

.info-pill {
    background: #fff; padding: 12px 25px; border-radius: 100px; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 10px;
    font-weight: 500; font-size: 14px;
}

.whatsapp-luxury {
    text-decoration: none; display: flex; align-items: center; gap: 10px;
    background: #25D366; color: #fff; padding: 12px 25px; border-radius: 100px;
    font-weight: 600; box-shadow: 0 8px 20px rgba(37, 211, 102, 0.2);
}

.whatsapp-luxury:hover { transform: scale(1.05); }
.whatsapp-luxury img { width: 20px; }

/* Main Button */
.main-cta {
    background: var(--text-dark); color: #fff; border: none; padding: 22px 50px;
    border-radius: 100px; font-size: 16px; font-weight: 700; cursor: pointer;
    position: relative; overflow: hidden;
}

.main-cta:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

/* ===== PRODUCTS GRID ===== */
.products-wrapper { display: none; padding-top: 40px; }
.products-wrapper.show { display: block; animation: slideUp 0.8s ease forwards; }

.section-title { display: flex; align-items: center; gap: 20px; margin-bottom: 50px; }
.section-title .line { flex: 1; height: 1px; background: #E0E0E0; }
.section-title h2 { font-family: 'Cormorant Garamond', serif; font-size: 32px; }

.products-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 35px;
}

.product-card {
    background: #fff; border-radius: 30px; padding: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}

.product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }

.image-box {
    height: 320px; border-radius: 22px; overflow: hidden; position: relative;
}

.image-box img { width: 100%; height: 100%; object-fit: cover; }

.sale-tag {
    position: absolute; top: 15px; left: 15px; background: var(--brand);
    color: #fff; padding: 6px 15px; border-radius: 50px; font-size: 11px; font-weight: 800; text-transform: uppercase;
}

.product-details { padding: 25px 15px 15px; text-align: center; }
.product-details h4 { margin: 0 0 10px 0; font-size: 20px; font-weight: 600; }

.price-box { margin-bottom: 20px; }
.new-price { font-size: 22px; font-weight: 800; color: var(--brand); }
.old-price { text-decoration: line-through; color: #BBB; margin-left: 8px; font-size: 14px; }
.regular-price { font-size: 20px; font-weight: 700; }

.view-item-btn {
    width: 100%; border: 1px solid #EEE; background: none; padding: 12px;
    border-radius: 15px; font-weight: 600; cursor: pointer;
}

.view-item-btn:hover { background: var(--text-dark); color: #fff; border-color: var(--text-dark); }

/* Scroll Reveal */
.reveal { opacity: 0; transform: translateY(30px); }
.reveal.visible { opacity: 1; transform: translateY(0); }

@keyframes slideUp { from { opacity:0; transform: translateY(40px); } to { opacity:1; transform: translateY(0); } }

@media (max-width: 768px) {
    .hero-section { padding: 60px 20px; }
    .shop-title { font-size: 45px; }
}
.view-item-btn {
    display: block; /* Makes the whole area clickable */
    text-decoration: none; /* Removes the underline */
    width: 100%; 
    border: 1px solid #EEE; 
    background: none; 
    padding: 12px;
    border-radius: 15px; 
    font-weight: 600; 
    color: var(--text-dark); /* Keeps the text color right */
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-item-btn:hover { 
    background: var(--text-dark); 
    color: #fff; 
    border-color: var(--text-dark); 
}
</style>

<script>
function toggleProducts() {
    const section = document.getElementById('productsSection');
    section.classList.add('show');
    section.scrollIntoView({ behavior: 'smooth' });
}

// Reveal logic
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});
</script>

</body>
</html>