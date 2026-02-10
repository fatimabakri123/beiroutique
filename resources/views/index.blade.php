{{-- resources/views/navbar.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Creative Shein-style Navbar</title>
 <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-papNMVb+Yk2JQw1RwqjksqDzk1p5lFf5C5KzQ8c9hJ/j2VrTNYAnrO+yFdhCzw5Lh0h9MtN2C5H+X0xwY1n5FA==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
/>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
 <!-- ====== Splash Screen ====== -->
<!--
<div id="splash">
  <video autoplay muted loop playsinline class="splash-video">
    <source src="{{ asset('image/Beige.mp4') }}" type="video/mp4">
  </video>
  <div class="splash-overlay"></div>

  
</div>

<style>
  /* Splash container */
  #splash {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 99999;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none; 
    transition: opacity 1s ease, visibility 1s ease;
  }

  /* Fullscreen video */
  .splash-video {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
   
    z-index: -2;
  }

  /* Overlay */
  .splash-overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
  
    z-index: -1;
  }

  /* Text content */
  .splash-text {
    text-align: center;
    color: #fff;
    padding: 20px 40px;
    background: rgba(0,0,0,0.25); 
    border-radius: 12px;
    animation: fadeInUp 1.8s ease forwards;
  }

  .splash-text h1 {
    font-size: 48px;
    font-weight: 900;
    letter-spacing: 0.1em;
    margin-bottom: 10px;
    animation: glow 2s ease-in-out infinite alternate;
  }

  .splash-text p {
    font-size: 18px;
    font-style: italic;
    letter-spacing: 0.04em;
    opacity: 0.9;
    animation: fadeIn 2.5s ease forwards 0.8s;
  }

  /* Animations */
  @keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
  }

  @keyframes glow {
    from { text-shadow: 0 0 8px #fff, 0 0 15px #eee; }
    to { text-shadow: 0 0 15px #ff8fab, 0 0 30px #f48fb1; }
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  /* Hide splash after load */
  body.loaded #splash {
    opacity: 0;
    visibility: hidden;
} -->
 


<script>
  window.addEventListener("load", function() {
    setTimeout(function(){
      document.body.classList.add("loaded");
    }, 3000); 
  });
</script>

<!-- ====== Navbar ====== -->
 <nav class="navbar-main" role="navigation" aria-label="Main navigation">
    <div class="logo">
      <img src="{{ asset('image/beiroutique2.png') }}" alt="Logo" width="50" height="50">
    </div>


<form method="POST" action="{{ route('search.image') }}" 
      class="vision-search-form" id="mainSearchForm" enctype="multipart/form-data">
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
            <div class="scan-line"></div> </div>

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

<style>
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
    border-color: #7413a4;
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
    border: 2px solid #9359c5d7;
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
    background: #7e16cd;
    box-shadow: 0 0 10px #9a1ded;
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
    color: #570789d7;
    margin-right: 15px;
    transition: color 0.3s;
    position: relative;
}

.camera-trigger:hover { color: #960adc9d; }

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
    box-shadow: 0 5px 15px rgba(113, 19, 156, 0.63);
}
</style>
<script>
const imageInput = document.getElementById('imageSearch');
const previewContainer = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');
const textSearch = document.getElementById('textSearch');

imageInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update preview image
            previewImg.src = e.target.result;
            // Show preview box
            previewContainer.style.display = 'block';
            // Fade out the text search a bit to focus on the image
            textSearch.placeholder = "Image uploaded! Analyzing...";
            
            // OPTIONAL: Auto-submit after 1 second of "scanning"
            setTimeout(() => { document.getElementById('mainSearchForm').submit(); }, 1200);
        }
        reader.readAsDataURL(file);
    }
});

function clearImage() {
    imageInput.value = "";
    previewContainer.style.display = 'none';
    textSearch.placeholder = "Search products, categories, shops...";
}
</script>






    

    <div class="nav-icons" role="navigation" aria-label="User navigation">
      @guest
        {{-- When user not logged in --}}
        <a href="{{ route('login') }}" aria-label="Account">
          <i class="fa-regular fa-user"></i>
        </a>
      @else
        {{-- When user is logged in --}}
        <div class="dropdown">
          <button class="dropbtn" aria-label="User Menu">
            <i class="fa-regular fa-user"></i>
          </button>
          <div class="dropdown-content">
            <a href="{{ route('customer.home') }}">Edit Profile</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="logout-btn">Logout</button>
            </form>
          </div>
        </div>
      @endguest

      <a href="{{route('customer.wishlist')}}" aria-label="Favorites" class="favorites">
        <i class="fa fa-heart"></i>
      </a>
      <a href="{{route('customer.cart')}}" aria-label="Cart">
        <i class="fa fa-shopping-cart"></i>
      </a>
    </div>
</nav>
<!-- ====== Category Bar ====== -->
  <nav class="category-bar" role="navigation" aria-label="Category navigation">
    <ul>
      <li><a href="#categories-section">Categories</a></li>
     <li><a href="{{ route('sale') }}">Sale</a></li>

      <li><a href="{{ url('/categories/1/products') }}">Women</a></li>
      <li><a href="{{ url('/categories/2/products') }}">Men </a></li>
       <li><a href="{{ url('/categories/3/products') }}">Kids</a></li>
      <li><a href="{{ url('/categories/6/products') }}">Home & Kitchen</a></li>
      <li><a href="{{ url('/categories/7/products') }}">Beauty & Health</a></li>
    </ul>
  </nav>

  
 
<div class="image-carousel" aria-label="Image carousel" role="region">
  <button class="carousel-btn prev" aria-label="Previous image">&lt;</button>

  <div class="carousel-track-container">
    <ul class="carousel-track">
      <li class="carousel-slide current-slide">
        <img src="{{ asset('image/image1.png') }}" alt="Description 1"  class="clothes"/>
      </li>
      <li class="carousel-slide">
        <img src="{{ asset('image/image2.png') }}" alt="Description 2" class="shoes"/>
      </li>
      <li class="carousel-slide">
        <img src="{{ asset('image/image5.png') }}" alt="Description 3" class="care"/>
      </li>
      <li class="carousel-slide">
        <img src="{{ asset('image/image4.png') }}" alt="Description 4" class="curve"/>
      </li>
    </ul>
  </div>

  <button class="carousel-btn next" aria-label="Next image">&gt;</button>

  <div class="carousel-nav">
    <button class="carousel-indicator current-slide" aria-label="Slide 1"></button>
    <button class="carousel-indicator" aria-label="Slide 2"></button>
    <button class="carousel-indicator" aria-label="Slide 3"></button>
    <button class="carousel-indicator" aria-label="Slide 4"></button>
  
  </div>
</div>



<script>
  document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(track.children);
    const nextButton = document.querySelector('.carousel-btn.next');
    const prevButton = document.querySelector('.carousel-btn.prev');
    const nav = document.querySelector('.carousel-nav');
    const indicators = Array.from(nav.children);

    let currentIndex = 0;

    const updateSlidePosition = (index) => {
      const slideWidth = slides[0].getBoundingClientRect().width;
      track.style.transform = `translateX(-${slideWidth * index}px)`;

      slides.forEach((slide, i) => {
        slide.classList.toggle('current-slide', i === index);
      });
      indicators.forEach((indicator, i) => {
        indicator.classList.toggle('current-slide', i === index);
      });
    };

    const moveToNextSlide = () => {
      currentIndex = (currentIndex + 1) % slides.length;
      updateSlidePosition(currentIndex);
    };

    const moveToPrevSlide = () => {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateSlidePosition(currentIndex);
    };

    nextButton.addEventListener('click', () => {
      moveToNextSlide();
      resetAutoSlide();
    });

    prevButton.addEventListener('click', () => {
      moveToPrevSlide();
      resetAutoSlide();
    });

    indicators.forEach((indicator, index) => {
      indicator.addEventListener('click', () => {
        currentIndex = index;
        updateSlidePosition(currentIndex);
        resetAutoSlide();
      });
    });

    // Auto slide every 4 seconds
    let autoSlide = setInterval(moveToNextSlide, 4000);

    function resetAutoSlide() {
      clearInterval(autoSlide);
      autoSlide = setInterval(moveToNextSlide, 4000);
    }

    updateSlidePosition(currentIndex);
  });
</script>
<section id="shops" class="shops-section">
  <div class="shops-trigger-container">
    <div class="floating-emoji e1">🛍️</div>
    <div class="floating-emoji e2">✨</div>
    <div class="floating-emoji e3">🔥</div>
    <div class="floating-emoji e4">💎</div>
    <div class="trigger-content">
      <h2 class="section-title">Start Your Jounery Now!</h2>
      <p class="section-description">Discover unique collections from our verified local shops</p>
      <button class="explore-btn-modern" onclick="toggleShops()">
        <span id="btnText">Explore Shops</span>
        <i class="fas fa-arrow-right" id="btnIcon"></i>
      </button>
    </div>
  </div>

  <div class="shops-list" id="shopsList">
    @foreach($shops ?? [] as $shop)
      <div class="shop-entry">
        <a class="shop-card-circle" href="{{ route('shop.products', $shop->shop_id) }}">
          <div class="circle-inner">
            <img src="{{ $shop->logo_url ? asset('storage/' . $shop->logo_url) : asset('images/default-shop.png') }}" 
                 alt="{{ $shop->shop_name }}">
            <div class="glass-overlay">VIEW</div>
          </div>
        </a>
        <div class="shop-info-text">
          <h3>{{ $shop->shop_name }}</h3>
          <span class="shop-loc"><i class="fas fa-map-marker-alt"></i> {{ $shop->address }}</span>
        </div>
      </div>
    @endforeach
  </div>


  <script>
    function toggleShops() {
      const list = document.getElementById('shopsList');
      const btnText = document.getElementById('btnText');
      const entries = list.querySelectorAll('.shop-entry');
      
      if (list.style.display === 'flex') {
        // Hide logic
        list.style.display = 'none';
        btnText.innerText = 'Explore Shops';
        // Remove classes so they can re-animate next time
        entries.forEach(el => el.classList.remove('animate-in'));
      } else {
        // Show logic
        list.style.display = 'flex';
        btnText.innerText = 'Close Shops';
        
        entries.forEach((entry, index) => {
          setTimeout(() => {
            entry.classList.add('animate-in');
          }, index * 100);
        });

        list.scrollIntoView({ behavior: 'smooth', block: 'center' });
const topPos = list.getBoundingClientRect().top + window.scrollY - 100; // adjust 100px as needed
window.scrollTo({ top: topPos, behavior: 'smooth' });

      }
    }
  function toggleShops() {
  const list = document.getElementById('shopsList');
  const btnText = document.getElementById('btnText');
  const btnIcon = document.getElementById('btnIcon');
  const entries = list.querySelectorAll('.shop-entry');

  if (list.style.display === 'flex') {
    list.style.display = 'none';
    btnText.innerText = 'Explore Universe';
    btnIcon.className = 'fas fa-rocket';
    entries.forEach(el => el.classList.remove('animate-in'));
  } else {
    list.style.display = 'flex';
    btnText.innerText = 'Close Universe';
    btnIcon.className = 'fas fa-times';

    entries.forEach((entry, index) => {
      setTimeout(() => entry.classList.add('animate-in'), index * 100);
    });

    // Smooth scroll with offset
    const topPos = list.getBoundingClientRect().top + window.scrollY - 80; // adjust offset
    window.scrollTo({ top: topPos, behavior: 'smooth' });
  }
}

  </script>
  
</section>

         

<!-- ====== Categories Section ====== -->
<section   id="categories-section" class="categories-section">
  <div class="categories-container">
     @foreach($categories ?? [] as $cat)
    <a class="category-card" href="{{ route('category.products', $cat->category_id) }}">

        <img src="{{ Str::startsWith($cat->image, 'http') ? $cat->image : asset('storage/' . ($cat->image ?? 'default.jpg')) }}"
             alt="{{ $cat->category_name }}" />
        <p>{{ $cat->category_name }}</p>
      </a>
    @endforeach
  </div>
</section>

<section class="deals-section">
    <h3>🔥 Deals & Offers</h3>
    <div class="deals-grid">
        @foreach($deals as $deal)
        <div class="deal-card">
          @php
    $images = $deal->images && $deal->images->count()
        ? $deal->images
        : collect([(object)['image_path' => $deal->image_url]]);
@endphp

<a href="{{ route('product.show', $deal->product_id) }}">
    <img
        src="{{ Str::startsWith($images->first()->image_path, 'products/')
            ? asset('storage/' . $images->first()->image_path)
            : asset($images->first()->image_path) }}"
        alt="{{ $deal->product_name }}"
        class="deal-img"
    >
</a>

            <p class="product-name">{{ $deal->product_name }}</p>
            <div class="prices">
                <span class="original-price">${{ $deal->price }}</span>
                <span class="discount-price">${{ $deal->price - $deal->discount_value }}</span>
            </div>
            <span class="discount-tag">-{{ $deal->discount_value }}$</span>
        </div>
        @endforeach
    </div>
    
</section>

<!-- ====== Shops Section ====== -->

        <style>/* ===== SHOPS SECTION ===== */
.shops-section {
    padding: 60px 40px;
    background: #f9f7f406;
}

.shops-container {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: center;
}

/* ===== SHOP CARD ===== */
.shop-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #5C3A21;
    transition: transform 0.35s, box-shadow 0.35s;
    width: 140px;
    position: relative;
}

.shop-card img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fdf2e9;
    transition: transform 0.35s, border-color 0.35s, box-shadow 0.35s;
}

.shop-card:hover img {
    transform: scale(1.2) rotate(-5deg);
    border-color:linear-gradient(135deg, #a359c5, #1638e2d3);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* ===== SHOP NAME ===== */
.shop-card p.shop-name {
    margin-top: 10px;
    font-weight: 600;
    text-align: center;
}

/* ===== SHOP LOCATION ===== */
.shop-card p.shop-location {
    font-size: 12px;
    color: #A67C52;
    text-align: center;
    margin-top: 4px;
}

/* ===== HOVER BUTTON ===== */
.shop-card::after {
    content: "View Shop →";
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    background: linear-gradient(135deg, #a359c5, #1638e2d3);
    color: #fff;
    padding: 6px 18px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 600;
    opacity: 0;
    transition: all 0.3s ease;
}

.shop-card:hover::after {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

</style>
    </div>
</section>

  
  <style>
    
 :root{
  --bg: #ffffff;
  --card: #ffffff;
  --accent:#cfa98f;
  --accent-dark:#b68566;
  --text:#2b2b2b;
  --muted:#6c5f58;
  --shadow:0 12px 35px rgba(0,0,0,0.12);
  --radius:22px;
  font-family: 'Poppins', sans-serif;
}

*{box-sizing:border-box;margin:0;padding:0}
body{
  background:var(--bg);
  color:var(--text);
  line-height:1.6;
  overflow-x:hidden;
}

/* Section with smooth bg transition */
.section{
  max-width:1200px;
  margin:0 auto;
  padding:100px 28px;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:50px;
  align-items:center;
  position:relative;
  opacity:0;
  transform:translateY(40px);
  transition:opacity 1s ease, transform 1s ease, background 1.5s ease;
  border-radius: var(--radius);
  background:linear-gradient(135deg, var(--card), var(--bg));
}
.section:nth-child(even){
  direction:rtl;
  background:linear-gradient(135deg, var(--bg), var(--card));
}
.section.visible{
  opacity:1;
  transform:translateY(0);
}

/* Image smaller & centered */
.section img{
  width:50%;         
  max-width:300px;    
  margin:auto;
  display:block;
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  transform:scale(1) rotate(0deg);
  transition:transform 1s cubic-bezier(.19,1,.22,1), box-shadow .5s ease;
}
.section img:hover{
  transform:scale(1.1) rotate(-1deg);
  box-shadow:0 20px 40px rgba(0,0,0,0.2);
}
  
  
/* ===== Home Categories (Responsive Grid) ===== */
.categories-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 28px;
    width: 100%;
}


/* Category item */
.category-card {
    background: transparent;
    text-align: center;
    text-decoration: none;
    color: #222;
}

/* Bigger image */
.category-card img {
    width: 155px;              /* ⬅️ bigger photos */
    height: 155px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
    transition: transform 0.35s ease, box-shadow 0.35s ease;
}

/* Smaller text */
.category-card p {
    font-size: 14px;           /* ⬅️ smaller words */
    font-weight: 600;
    margin: 0;
}

/* Hover effect */
.category-card:hover img {
    transform: scale(1.08);
    box-shadow: 0 12px 28px rgba(0,0,0,0.18);
}

/* ===== Categories full width ===== */
.categories-section {
    width: 100vw;
    max-width: 100%;
    margin: 40px 0;
    padding: 0 40px;
}


  

/* Content */
.section-content{padding:10px;}

/* Title with animated underline */
.section h2{
  font-size:36px;
  margin-bottom:20px;
  font-weight:700;
  position:relative;
  display:inline-block;
}
.section h2::after{
  content:'';
  display:block;
  width:0;
  height:4px;
  background:linear-gradient(90deg,var(--accent),var(--accent-dark));
  margin-top:10px;
  border-radius:4px;
  transition:width .6s ease;
}
.section.visible h2::after{width:100%;}

/* Paragraph */
.section p{
  color:var(--muted);
  font-size:17px;
  margin-bottom:24px;
  line-height:1.8;
  opacity:0;
  transform:translateY(20px);
  transition:opacity .8s ease, transform .8s ease;
}
.section.visible p{
  opacity:1;
  transform:translateY(0);
  transition-delay:.3s;
}

/* Button */
.highlight{
  background:linear-gradient(135deg,var(--accent),var(--accent-dark));
  color:#fff;
  padding:12px 20px;
  border-radius:14px;
  display:inline-block;
  font-weight:600;
  cursor:pointer;
  box-shadow:0 6px 18px rgba(0,0,0,0.2);
  transition:transform .4s ease, box-shadow .4s ease;
}
.highlight:hover{
  transform:translateY(-4px) scale(1.05);
  box-shadow:0 10px 25px rgba(0,0,0,0.25);
}

/* Responsive */
@media(max-width:900px){
  .section{grid-template-columns:1fr;gap:30px;padding:70px 22px}
  .section:nth-child(even){direction:ltr}
  .section img{width:70%; max-width:250px;}
  .section h2{font-size:28px}
}  

  </style>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll(".section");

  const reveal = () => {
    const trigger = window.innerHeight * 0.8;
    sections.forEach(sec => {
      const top = sec.getBoundingClientRect().top;
      if(top < trigger){ sec.classList.add("visible"); }
    });
  };

  window.addEventListener("scroll", reveal);
  reveal();
});
</script>

  <!-- ====== About Intro ====== -->
 



<!-- ====== Trending Now====== -->
 <section class="trending-section">

  <h2 style="text-align:center; margin-bottom: 20px;">Trending Now</h2>
  <div class="cards-row">
       @forelse($topProducts as $index => $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded p-1 text-center" style="width:30px;height:30px;line-height:28px;">
                                        
                                    </div>
                                    <div>
                                       
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
     <div class="fw-medium text-truncate" style="max-width:120px">{{ $product->product_name }}</div>
                                        <small class="text-muted">{{ $product->shop->shop_name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">No sales data yet</td>
                        </tr>
                        @endforelse
</div>
  </div>
  <style>
    /* Trending Section */
/* ===== TRENDING HORIZONTAL CARDS ===== */
.trending-section {
    max-width: 1500px;
    margin: 50px auto;
    padding: 10px;
}

.trending-section h2 {
    font-weight: 800;
    color: #421a76;
    text-align: center;
    margin-bottom: 25px;
    font-family: 'Poppins', sans-serif;
}

/* cards row */
.trending-section .cards-row {
    display: flex;
    gap: 50px;
    overflow-x: auto;
    padding-bottom: 15px;
    scrollbar-width: none;
}
.trending-section .cards-row::-webkit-scrollbar {
    display: none;
}

/* each card */
.trending-section tr {
    min-width: 260px;
    background: #fff;
    border-radius: 20px;
    padding: 18px 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: 0.3s;
    flex-shrink: 0;
    text-align: center;
}

.trending-section tr:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* circle image */
.trending-section .slider-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    margin: 10px auto 12px;
    display: block;
    border: 4px solid #eee;
}

/* product name */
.trending-section .fw-medium {
    font-size: 16px;
    font-weight: 700;
    color: #501590;
}

/* shop name */
.trending-section small.text-muted {
    font-size: 18px;
    display: block;
    margin-bottom: 10px;
}

/* stats row */
.trending-section td.text-end {
    margin-top: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* sold */
.trending-section .fw-bold {
    font-size: 18px;
    color: #111;
}

/* revenue */
.trending-section .text-success {
    font-weight: 700;
    color: #16a34a !important;
}

/* responsive */
@media (max-width: 600px) {
    .trending-section tr {
        min-width: 220px;
    }
    .trending-section .slider-img {
        width: 90px;
        height: 90px;
    }
}
.trending-section .cards-row {
    justify-content: center;  
}

  </style>
</section>

<!-- ====== Testimonials Section ====== -->
@php
    use App\Models\Testimonial;
    $testimonials = Testimonial::where('is_featured', true)->take(3)->get();
@endphp

<section class="testimonials-professional">
  <h2 class="testimonials-title-professional">What Our Customers Say</h2>
  <div class="testimonial-cards-professional">
    @foreach($testimonials as $testimonial)
      <div class="testimonial-bubble">
        <div class="testimonial-avatar">
          <img src="{{ asset($testimonial->image_url) }}" alt="{{ $testimonial->name }}">
        </div>
        <div class="testimonial-content">
          <p class="testimonial-message">"{{ $testimonial->message }}"</p>
          <h4 class="testimonial-name">{{ $testimonial->name }}</h4>
          <p class="testimonial-occupation">{{ $testimonial->occupation }}</p>
        </div>
      </div>
    @endforeach
  </div>
</section>



  <style>
    /* ====== Professional Testimonials ====== */

/* ===== Testimonials Section ===== */
.testimonials-professional {
  background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
  padding: 90px 20px;
  text-align: center;
  font-family: "Poppins", sans-serif;
  position: relative;
  overflow: hidden;
}

/* ===== Title ===== */
.testimonials-title-professional {
  font-size: 2.6rem;
  font-weight: 700;
  color: var(--white);
  margin-bottom: 60px;
  letter-spacing: 1px;
}

.testimonials-title-professional::after {
  content: "";
  display: block;
  width: 70px;
  height: 3px;
  background: var(--white);
  margin: 14px auto 0;
  border-radius: 4px;
  opacity: 0.7;
}

/* ===== Cards Wrapper ===== */
.testimonial-cards-professional {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 45px;
  max-width: 1100px;
  margin: 0 auto;
}

/* ===== Bubble Card ===== */
.testimonial-bubble {
  background: var(--bg-light);
  border-radius: 50px;
  padding: 40px 30px 30px;
  width: 300px;
  position: relative;
  box-shadow: var(--shadow-soft);
  transition: all 0.4s ease;
  border: 1px solid var(--border-soft);
  display: flex;
  flex-direction: column;
  align-items: center;
  animation: floatUp 0.9s ease forwards;
  opacity: 0;
}

.testimonial-bubble:hover {
  transform: translateY(-10px) scale(1.05);
}

/* ===== Avatar ===== */
.testimonial-avatar {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  overflow: hidden;
  border: 4px solid var(--purple-dark);
  box-shadow: 0 0 18px rgba(0,0,0,0.15);
  margin-top: -80px;
  background: var(--white);
}

.testimonial-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* ===== Content ===== */
.testimonial-content {
  margin-top: 20px;
}

.testimonial-message {
  background: var(--white);
  padding: 18px 22px;
  border-radius: 20px 20px 20px 0px;
  font-size: 1rem;
  color: var(--text-dark);
  line-height: 1.6;
  font-style: italic;
  margin-bottom: 20px;
  border: 1px solid var(--border-soft);
}

.testimonial-name {
  font-size: 1.4rem;
  font-weight: 600;
  color: var(--purple-dark);
  margin-bottom: 4px;
}

.testimonial-occupation {
  font-size: 1rem;
  color: var(--text-muted);
}

/* ===== Animations ===== */
@keyframes floatUp {
  from { opacity: 0; transform: translateY(40px) scale(0.95); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}

.testimonial-bubble:nth-child(1) { animation-delay: 0.1s; }
.testimonial-bubble:nth-child(2) { animation-delay: 0.3s; }
.testimonial-bubble:nth-child(3) { animation-delay: 0.5s; }
.testimonial-bubble:nth-child(4) { animation-delay: 0.7s; }

    </style>
</section>


<!-- ====== SHEIN Style Footer - Brown & Beige + Payment ====== -->


<footer class="shein-footer">
    <div class="footer-top">
        <div class="footer-column">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="#categories-section"><i class="fas fa-tags"></i> Categories</a></li>
                <li><a href="#shops"><i class="fas fa-store"></i> Sellers</a></li>
             <li class="about-dropdown">
    <a href="javascript:void(0)" onclick="toggleBioBox()">
        <i class="fas fa-info-circle"></i> About
    </a>

    <div id="bioBox" class="bio-dropdown-box">
        <p><strong>About Our Website</strong></p>
        <p>
            Our platform connects customers with local shops in one place.
            Browse, compare, and support small businesses easily.
        </p>
    </div>
</li>


                <li><a href="#contact"><i class="fas fa-envelope"></i> Contact</a></li>
                <li><a href="#faq"><i class="fas fa-question-circle"></i> FAQ</a></li>
            </ul>
    
<script>
function toggleBioBox() {
    const box = document.getElementById("bioBox");
    box.style.display = box.style.display === "block" ? "none" : "block";
}
</script>


        </div>

       <div class="footer-column">
    <h4>Customer Service</h4>
    <ul class="cs-list">
        <li>
            <a href="#" onclick="toggleInfo(event,'shipping')">
                <i class="fas fa-truck"></i> Shipping Info
            </a>
            <div class="cs-box" id="shipping">
                Orders are received either from the shop location or via delivery depending on the seller.
            </div>
        </li>

        <li>
            <a href="#" onclick="toggleInfo(event,'returns')">
                <i class="fas fa-exchange-alt"></i> Returns & Exchanges
            </a>
            <div class="cs-box" id="returns">
                Return and exchange policies depend on each shop and its owner.
            </div>
        </li>

        <li>
            <a href="#" onclick="toggleInfo(event,'payment')">
                <i class="fas fa-credit-card"></i> Payment Options
            </a>
            <div class="cs-box" id="payment">
                Credit Card, Bank Transfer, or Cash on Delivery.
            </div>
        </li>

        <li>
            <a href="#" onclick="toggleInfo(event,'support')">
                <i class="fas fa-headset"></i> Support
            </a>
            <div class="cs-box" id="support">
                Contact the shop directly or use our support form.
            </div>
        </li>
    </ul>
    <style>
      .cs-list li {
    position: relative;
    margin-bottom: 8px;
}

.cs-box {
    display: none;
    background: #fff;
    color: #333;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 13px;
    margin-top: 6px;
    box-shadow: 0 5px 12px rgba(0,0,0,0.15);
    animation: fadeIn .25s ease;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-5px);}
    to {opacity: 1; transform: translateY(0);}
}
    </style>
</div>



        <div class="footer-column">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                <a href="#"><ion-icon name="logo-whatsapp"></ion-icon></a>
                <a href="#"><ion-icon name="logo-tiktok"></ion-icon></a>
            </div>
        </div>

        <div class="footer-column">
            <h4>Newsletter</h4>
            <p>Subscribe for latest updates & offers!</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe <i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>

    <!-- ====== Payment Methods ====== -->
    <div class="footer-payment">
        <h4>Payment Methods</h4>
        <div class="payment-icons">
            <img src="{{asset('image/visa.jpg')}}" alt="Visa">
  
            <img src="{{asset('image/omt.webp')}}" alt="OMT">
          
            <img src="{{asset('image/cash.png')}}" alt="Cash on Delivery">
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025 Beiroutique. All Rights Reserved. | Made with <i class="fas fa-heart" style="color: #FFE4C4;"></i> in Lebanon</p>
    </div>
</footer>

<script>
    // Newsletter form submission
    document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        if (email) {
            // Add animation to button
            const btn = this.querySelector('button');
            btn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
            btn.style.background = '#2E8B57'; // SeaGreen
            
            setTimeout(() => {
                btn.innerHTML = 'Subscribe <i class="fas fa-paper-plane"></i>';
                btn.style.background = '#8B4513';
                this.reset();
            }, 2000);
        }
    });

</script>
<script>
function toggleInfo(e, id) {
    e.preventDefault();

    const box = document.getElementById(id);

    // close other open boxes
    document.querySelectorAll('.cs-box').forEach(el => {
        if (el !== box) el.style.display = "none";
    });

    // toggle selected one
    box.style.display = (box.style.display === "block") ? "none" : "block";
}
</script>
<style>
/* ===== Modern Footer CSS (Purple + Blue Theme) ===== */
.shein-footer {
  background: #f9f9ff; /* very light purple-blue background */
  color: #1e1b4b;      /* dark blue text */
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  padding: 50px 20px 30px;
  border-top: 2px solid #d3d3f0;
}

.shein-footer a {
  color: #5b2a86; /* purple accent */
  text-decoration: none;
  transition: 0.3s ease-in-out;
}

.shein-footer a:hover {
  color: #1f7bb8; /* blue hover accent */
  transform: translateX(3px);
}

/* Footer Top */
.footer-top {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 40px;
  max-width: 1200px;
  margin: auto;
  padding-bottom: 40px;
  border-bottom: 1px solid #d3d3f0;
}

.footer-column h4 {
  font-size: 25px;
  margin-bottom: 20px;
  letter-spacing: 1px;
  font-weight: 600;
  color: #5b2a86; /* purple titles */
}

.footer-column ul {
  list-style: none;
  padding: 0;
}

.footer-column ul li {
  margin-bottom: 12px;
  font-size: 18px;
  transition: color 0.3s;
}

.footer-column ul li:hover {
  color: #1f7bb8;
}

/* About/Bio Box */
.bio-dropdown-box {
  display: none;
  background: #e4e4ff;
  color: #1e1b4b;
  padding: 12px 15px;
  margin-top: 8px;
  border-radius: 10px;
  box-shadow: 0 5px 12px rgba(0,0,0,0.15);
  font-size: 14px;
}

/* Customer Service Boxes */
.cs-box {
  display: none;
  background: #e4e4ff;
  color: #1e1b4b;
  padding: 8px 12px;
  border-radius: 8px;
  font-size: 13px;
  margin-top: 6px;
  box-shadow: 0 5px 12px rgba(0,0,0,0.15);
  animation: fadeIn .25s ease;
}

@keyframes fadeIn {
  from {opacity: 0; transform: translateY(-5px);}
  to {opacity: 1; transform: translateY(0);}
}

/* Social Icons */
.social-icons {
  display: flex;
  gap: 15px;
  margin-top: 10px;
}

.social-icons a {
  display: inline-block;
  font-size: 25px;
  color: #5b2a86;
  transition: transform 0.3s, color 0.3s;
}

.social-icons a:hover {
  color: #1f7bb8;
  transform: scale(1.2);
}

/* Newsletter */
.newsletter-form {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.newsletter-form input {
  flex: 1;
  padding: 12px;
  border: 1px solid #aaaaff;
  border-radius: 25px;
  outline: none;
  background-color: #fff;
  color: #1e1b4b;
  font-size: 16px;
  transition: border 0.3s, box-shadow 0.3s;
}

.newsletter-form input:focus {
  border-color: #5b2a86;
  box-shadow: 0 0 6px #7b42d8;
}

.newsletter-form button {
  padding: 12px 20px;
  border: none;
  background-color: #5b2a86;
  color: #fff;
  border-radius: 25px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.3s, transform 0.3s;
}

.newsletter-form button:hover {
  background-color: #1f7bb8;
  transform: translateY(-2px);
}

/* Payment Section */
.footer-payment {
  background: #f0f0ff;
  color: #1e1b4b;
  padding: 30px 20px;
  text-align: center;
  margin-top: 20px;
  border-top: 1px solid #d3d3f0;
}

.payment-icons {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
  padding-top: 15px;
}

.payment-icons img {
  width: 70px;
  height: auto;
  border-radius: 10px;
  transition: transform 0.3s, box-shadow 0.3s;
  cursor: pointer;
}

.payment-icons img:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

/* Footer Bottom */
.footer-bottom {
  text-align: center;
  padding: 20px;
  font-size: 14px;
  color: #666;
  border-top: 1px solid #d3d3f0;
}

/* Responsive */
@media (max-width: 900px) {
  .footer-top {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .footer-column {
    width: 100%;
  }

  .newsletter-form {
    flex-direction: column;
  }

  .newsletter-form button {
    width: 100%;
  }

  .payment-icons img {
    width: 50px;
  }
}

</style>

</body>
</html>