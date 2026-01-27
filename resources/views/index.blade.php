{{-- resources/views/navbar.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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
 
</style>

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


<form method="POST" action="{{ route('search') }}" 
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
    --gold-gradient: linear-gradient(135deg, #C5A059, #8C6C3E);
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
    border-color: #C5A059;
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
    border: 2px solid #C5A059;
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
    background: #C5A059;
    box-shadow: 0 0 10px #C5A059;
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

.camera-trigger:hover { color: #C5A059; }

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
        <a href="{{ route('register') }}" aria-label="Account">
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
        <img src="{{ asset('image/Home page.png') }}" alt="Description 1"  class="clothes"/>
      </li>
      <li class="carousel-slide">
        <img src="{{ asset('image/shoes.png') }}" alt="Description 2" class="shoes"/>
      </li>
      <li class="carousel-slide">
        <img src="{{ asset('image/care.jpg') }}" alt="Description 3" class="care"/>
      </li>
      <li class="carousel-slide">
        <img src="{{ asset('image/esharb.png') }}" alt="Description 4" class="curve"/>
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
<!--------- shops Section===-->
<section id="shops" class="shops-section">
  <div class="shops-banner">
    <img src="{{ asset('image/Shops.png') }}" alt="Shops Banner" class="banner-img">
    <button class="explore-btn" onclick="showShops()">Explore Our Shops</button>
  </div>

  <div class="shops-list" id="shopsList">
    @foreach($shops ?? [] as $shop)
      <a class="shop-card" href="{{ route('shop.products', $shop->shop_id) }}">
        <img src="{{ $shop->logo_url 
                     ? asset('storage/' . $shop->logo_url) 
                     : asset('images/default-shop.png') }}"
             alt="{{ $shop->shop_name }}">
        <p>{{ $shop->shop_name }}</p>
        <p>{{ $shop->location }}</p>
        <p>{{ $shop->description }}</p>
      </a>
    @endforeach
  </div>
</section>

         <style>
          .shops-list {
  display: none; /* مخفية بالبداية */
  gap: 20px;
  margin-top: 30px;
  flex-wrap: wrap;
}

.shops-section {
  text-align: center;
  margin: 50px 0;
}

.shops-banner {
  position: relative;
  display: inline-block;
}

.banner-img {
  width: 600px;
  max-height: 500px;
  
  object-fit: cover;
  border-radius: 10px;
}

.explore-btn {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  background-color: #bfa36f; /* لون luxury/classic */
  color: white;
  border: none;
  padding: 12px 25px;
  font-size: 18px;
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.explore-btn:hover {
  background-color: #8c6b3e;
}
  
.shops-list {
  display: none; 
  margin-top: 30px;

  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
}

.shop-item {
  background-color: #f5f5f5;
  padding: 15px 25px;
  border-radius: 8px;
  box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
  font-weight: bold;
}
</style>


<script>
function showShops() {
  const shops = document.getElementById('shopsList');
  shops.style.display = shops.style.display === 'flex' ? 'none' : 'flex';
}
</script>


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


<!-- ====== Shops Section ====== -->
<section id="shops-section" class="shops-section">
    <div class="shops-container">
        @foreach($shops ?? [] as $shop)
        <a class="shop-card" href="{{ route('shop.products', $shop->shop_id) }}">
            <img src="{{ $shop->logo_url 
                         ? asset('storage/' . $shop->logo_url) 
                         : asset('images/default-shop.png') }}"
                 alt="{{ $shop->shop_name }}" />
            <p>{{ $shop->shop_name }}</p>
            <p>{{ $shop->location }}</p>
            <p>{{ $shop->description }}</p>
        </a>
        @endforeach
        <style>/* ===== SHOPS SECTION ===== */
.shops-section {
    padding: 60px 40px;
    background: #f9f7f4;
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
    border-color: #D4A373;
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
    background: linear-gradient(135deg, #B08968, #7F5539);
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
 <section >
  <h2 style="text-align:center; margin-bottom: 20px;">Trending Now</h2>
  <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
      <div class="product-card">
          <img src="{{ asset('image/trendingDress.jpg') }}" alt="Trending 1" />
          <p class="title">Dresses</p>
          <p class="price">$30.00</p>
      </div>
      <div class="product-card">
          <img src="{{ asset('image/t-shirt.jpg') }}" alt="Trending 2" />
          <p class="title">T-Shirts</p>
          <p class="price">$40.00</p>
      </div>
      <div class="product-card">
          <img src="{{ asset('image/jeans.jpg') }}" alt="Trending 3" />
          <p class="title">Jeans</p>
          <p class="price">$50.00</p>
      </div>
      <div class="product-card">
          <img src="{{ asset('image/sneaker.jpg') }}" alt="Trending 4" />
          <p class="title">Sneakers</p>
          <p class="price">$60.00</p>
      </div>
      <div class="product-card">
          <img src="{{ asset('image/handbag.jpg') }}" alt="Trending 5" />
          <p class="title">Handbags</p>
          <p class="price">$18.00</p>
      </div>
        <div class="product-card">
          <img src="{{ asset('image/sunscreen.jpg') }}" alt="Trending 5" />
          <p class="title">L'adora sunscreen</p>
          <p class="price">$10.00</p>
      </div>

  </div>
  <style>
    /* Trending Section */
section {
    padding: 40px 20px;
    background-color: #f9f9f9;
}

section h2 {
    font-size: 28px;
    color: #1e1e2f;
    margin-bottom: 30px;
    font-weight: 600;
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

/* Product Card */
.product-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    padding-bottom: 15px;
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    border-bottom: 1px solid #eee;
}

/* Hover effect */
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Product Title */
.product-card .title {
    font-size: 16px;
    font-weight: 500;
    margin: 12px 0 5px;
    color: #333;
}

/* Product Price */
.product-card .price {
    font-size: 14px;
    color: #555;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .product-card img {
        height: 180px;
    }
    section h2 {
        font-size: 24px;
    }
}
/* Product Grid - Centered */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    justify-content: center; /* centers the grid */
    max-width: 1200px;       /* optional: limits width */
    margin: 0 auto;          /* center the container */
}

/* Optional: if you want each card to shrink to content */
.product-card {
    width: 200px; /* fixed width */
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

.testimonials-professional {
  background: radial-gradient(circle at top left, #ffff);
  padding: 90px 20px;
  text-align: center;
  font-family: "Poppins", sans-serif;
  position: relative;
  overflow: hidden;
}

.testimonials-title-professional {
  font-size: 2.6rem;
  font-weight: 700;
  color: #4b3b2b;
  margin-bottom: 60px;
  position: relative;
  letter-spacing: 1px;
}

.testimonials-title-professional::after {
  content: "";
  display: block;
  width: 70px;
  height: 3px;
  background: #b08b6701;
  margin: 14px auto 0;
  border-radius: 4px;
}
.testimonial-cards-professional {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 45px;
  max-width: 1100px;
  margin: 0 auto;
}


.testimonial-bubble {
  background: #fffaf4;
  border-radius: 60px;
  padding: 40px 30px 30px;
  width: 300px;
  position: relative;
  box-shadow: 0 8px 25px rgba(139, 94, 60, 0.15);
  transition: all 0.4s ease;
  border: 1px solid #e6d6c4;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.testimonial-bubble:hover {
  transform: translateY(-8px) scale(1.03);
  box-shadow: 0 12px 35px rgba(139, 94, 60, 0.25);
}


.testimonial-avatar {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  overflow: hidden;
  border: 4px solid #c5a880;
  box-shadow: 0 0 20px rgba(197, 168, 128, 0.4);
  margin-top: -80px;
  background: #fff;
}

.testimonial-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}


.testimonial-content {
  margin-top: 20px;
}

.testimonial-message {
  background: #f8f2ea;
  padding: 18px 22px;
  border-radius: 20px 20px 20px 0px;
  font-size: 1rem;
  color: #4b3b2b;
  line-height: 1.6;
  font-style: italic;
  margin-bottom: 20px;
  border: 1px solid #e6d6c4;
}

.testimonial-name {
  font-size: 1.2rem;
  font-weight: 600;
  color: #3b2d1e;
  margin-bottom: 4px;
}

.testimonial-occupation {
  font-size: 0.95rem;
  color: #8a7258;
}


@keyframes floatUp {
  from { opacity: 0; transform: translateY(40px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

.testimonial-bubble {
  animation: floatUp 0.9s ease forwards;
  opacity: 0;
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
        <li><a href="#categories-section">Categories</a></li>
        <li><a href="#sellers">Sellers</a></li>
        <li><a href="{{ url('/bio') }}">About</a></li>

        <li><a href="#contact">Contact</a></li>
        <li><a href="#faq">FAQ</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h4>Customer Service</h4>
      <ul>
        <li><a href="#shipping">Shipping Info</a></li>
        <li><a href="#returns">Returns & Exchanges</a></li>
        <li><a href="#payment">Payment Options</a></li>
        <li><a href="#support">Support</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h4>Follow Us</h4>
      <div class="social-icons">
        <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
        <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
        <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
        <a href="#"><ion-icon name="logo-whatsapp"></ion-icon></a>
      </div>
    </div>

    <div class="footer-column">
      <h4>Newsletter</h4>
      <p>Subscribe for latest updates & offers!</p>
      <form class="newsletter-form">
        <input type="email" placeholder="Enter your email">
        <button type="submit">Subscribe</button>
      </form>
    </div>
  </div>

  <!-- ====== Payment Methods ====== -->
  <div class="footer-payment">
    <h4>Payment Methods</h4>
    <div class="payment-icons">
      <img src="{{asset('image/visa.jpg')}}" alt="Visa">
      <img src="{{asset('image/paypal.jpg')}}" alt="PayPal">
      <img src="{{asset('image/omt.webp')}}" alt="omt">
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 YourShopName. All Rights Reserved.</p>
  </div>
</footer>
</body>
</html>