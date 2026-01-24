{{-- resources/views/about.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Beiroutique</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f9f7f6; margin:0; padding:0; }

    /* ===== Hero Section ===== */
    .hero {
      position: relative;
      text-align: center;
      color: #fff;
      padding: 120px 20px;
      background: url('{{ asset("image/ebanon.jpg") }}') center/cover no-repeat;
    }
    .hero h1 { font-size: 3rem; margin-bottom: 20px; animation: fadeInDown 1s ease forwards; }
    .hero p { font-size: 1.2rem; max-width: 700px; margin: 0 auto; animation: fadeInUp 1s ease 0.5s forwards; opacity: 0; }

    @keyframes fadeInDown { 0% { opacity:0; transform: translateY(-30px);} 100% { opacity:1; transform: translateY(0);} }
    @keyframes fadeInUp { 0% { opacity:0; transform: translateY(30px);} 100% { opacity:1; transform: translateY(0);} }

    /* ===== Section Styling ===== */
    .section { max-width: 1000px; margin: 60px auto; padding: 0 20px; }
    .section h2 { font-size: 2.2rem; color: #8B5E3C; margin-bottom: 25px; text-align: center; }
    .section p { font-size: 1.05rem; color: #444; line-height: 1.7; margin-bottom: 15px; text-align: center; }

    /* ===== Values ===== */
    .values { display: flex; flex-wrap: wrap; justify-content: space-around; gap: 30px; margin-top: 40px; }
    .value-card {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 25px rgba(0,0,0,0.08);
      width: 250px;
      text-align: center;
      transform: translateY(50px);
      opacity: 0;
      transition: all 0.7s ease;
    }
    .value-card i { font-size: 2.5rem; color: #8B5E3C; margin-bottom: 15px; }
    .value-card.active { transform: translateY(0); opacity: 1; }

    /* ===== Team ===== */
    .team { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; margin-top: 40px; }
    .team-member {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 6px 25px rgba(0,0,0,0.08);
      width: 250px;
      text-align: center;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .team-member:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
    .team-member img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; }
    .team-member h4 { font-size: 1.2rem; margin-bottom: 5px; color: #333; }
    .team-member p { font-size: 0.95rem; color: #8B5E3C; margin-bottom: 0; }


   .hero {
  position: relative;
  height: 500px; /* adjust to fit your design */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: #fff;
  font-family: 'Inter', sans-serif;
  overflow: hidden;

  /* Gradient + subtle texture overlay */
  background: linear-gradient(135deg, #f5e5d8, #d8bfa6, #8b5e3c);
  background-size: 400% 400%;

  /* Animate the gradient */
  animation: gradientShift 15s ease infinite;
}

/* Gradient animation */
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Optional: add a semi-transparent overlay for depth */
.hero::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.25); /* subtle dark overlay */
  pointer-events: none;
}

/* Hero text styling */
.hero h1 {
  font-size: 3rem;
  font-weight: 700;
  letter-spacing: 1px;
  z-index: 1;
  margin-bottom: 15px;
}

.hero p {
  font-size: 1.2rem;
  max-width: 700px;
  z-index: 1;
}


    /* ===== Scroll Animation ===== */
    .fade-up { transform: translateY(50px); opacity: 0; transition: all 0.7s ease; }
    .fade-up.active { transform: translateY(0); opacity: 1; }

    @media (max-width: 768px) { .values, .team { flex-direction: column; align-items: center; } }
  </style>
</head>
<body>

{{-- ======= NAVBAR ======= --}}
<nav class="navbar-main" role="navigation" aria-label="Main navigation">
  <div class="logo">
    <img src="{{ asset('image/logo2.png') }}" alt="Logo" width="50" height="50">
  </div>
  <form class="search-container" role="search" action="{{ url('/search') }}" method="GET">
    <input type="search" name="q" placeholder="Search for products, brands and more..." aria-label="Search" />
    <button type="submit" aria-label="Submit search"><i class="fa fa-search"></i></button>
  </form>
  <div class="nav-icons" role="navigation" aria-label="User navigation">
    <a href="#" aria-label="Account"><i class="fa-regular fa-user"></i></a>
    <a href="/favorites" aria-label="Favorites" class="favorites"><i class="fa fa-heart"></i></a>
    <a href="/cart" aria-label="Cart"><i class="fa fa-shopping-cart"></i></a>
  </div>
</nav>

<nav class="category-bar" role="navigation" aria-label="Category navigation">
    <ul>
      <li><a href="{{ url('/women') }}">Categories</a></li>
      <li><a href="{{ url('/new-in') }}">New In</a></li>
      <li><a href="{{ url('/sale') }}">Sale</a></li>
      <li><a href="{{ url('/women-clothing') }}">Women Clothing</a></li>
      <li><a href="{{ url('/kids') }}">Kids</a></li>
      <li><a href="{{ url('/curve') }}">Curve</a></li>
      <li><a href="{{ url('/men-clothing') }}">Men Clothing</a></li>
      <li><a href="{{ url('/shoes') }}">Shoes</a></li>
      <li><a href="{{ url('/underwear-sleepwear') }}">Underwear & Sleepwear</a></li>
      <li><a href="{{ url('/home-kitchen') }}">Home & Kitchen</a></li>
      <li><a href="{{ url('/jewelry-accessories') }}">Jewelry & Accessories</a></li>
      <li><a href="{{ url('/beauty-health') }}">Beauty & Health</a></li>
      <li><a href="{{ url('/baby-maternity') }}">Baby & Maternity</a></li>
      <li><a href="{{ url('/bags-luggage') }}">Bags & Luggage</a></li>
      <li><a href="{{ url('/sports-outdoors') }}">Sports & Outdoors</a></li>
      <li><a href="{{ url('/home-textiles') }}">Home Textiles</a></li>
      <li><a href="{{ route('bio') }}">About Us</a></li>

    </ul>
  </nav>

{{-- ===== Hero ===== --}}
<section class="hero">
  <h1>Welcome to Beiroutique</h1>
  <p>Your destination for chic fashion and lifestyle essentials. Style, quality, and elegance in one place.</p>
</section>

<section class="section">
    <div>
      <img src={{asset("/image/beiroutique2.png")}} alt="Beiroutique store design">
    </div>
    <div class="section-content">
      <h2>Our Story</h2>
      <p>Beiroutique was born as a digital-first marketplace, designed to make shopping in Lebanon easier, smarter, and more inspiring.
We are not a traditional shop — we are an online destination where customers can explore the latest trends, and shop owners can showcase their products, grow their business, and connect with a wider audience.
Our goal is simple: to bridge the gap between local creativity and modern shopping needs. Whether you’re a shopper looking for unique finds or a business owner seeking visibility, Beiroutique is here to empower your journey.</p>
      <span class="highlight">Authenticity in Every Piece</span>
    </div>
  </section>

  <!-- ====== Our Mission ====== -->
  <section class="section">
    <div>
      <img src={{asset("/image/crafted.jpg")}} alt="Crafted fashion items">
    </div>
    <div class="section-content">
      <h2>Our Mission</h2>
      <p>Our mission is to transform the way Lebanon shops and sells online.
We provide a platform that makes shopping effortless for customers, while giving businesses the tools they need to market, manage, and expand their brand digitally.</p>
      <span class="highlight">Style Meets Culture</span>
    </div>
  </section>

  <!-- ====== Our Values ====== -->
  <section class="section">
    <div>
      <img src={{asset("/image/team.jpg")}} alt="Team working together">
    </div>
    <div class="section-content">
      <h2>Our Values</h2>
      <p>
       Innovation – We bring the latest digital tools to support modern shopping.

Community – We connect shoppers and sellers to grow together.

Accessibility – Everyone deserves a simple, secure, and enjoyable online shopping experience.

Empowerment – We give business owners visibility and control over their growth.
      <span class="highlight">Community First</span>
    </div>
  </section>

  <!-- ====== Our Promise ====== -->
  <section class="section">
    <div>
      <img src={{asset("/image/customer.jpg")}} alt="Happy customer shopping">
    </div>
    <div class="section-content">
      <h2>Our Promise</h2>
      <p>At Beiroutique, we promise to always be a trusted online space where shopping meets convenience, and where sellers find the support they need to shine.
We are committed to building a marketplace that celebrates local talent while offering global-level shopping experiences.</p>
      <span class="highlight">Quality & Care</span>
    </div>
  </section>

{{-- ===== Our Values ===== --}}
<section class="section fade-up">
  <h2>Our Values</h2>
  <div class="values">
    <div class="value-card">
      <i class="fa fa-leaf"></i>
      <h4>Sustainability</h4>
      <p>Eco-conscious choices in all aspects of our business.</p>
    </div>
    <div class="value-card">
      <i class="fa fa-heart"></i>
      <h4>Customer Care</h4>
      <p>Our customers are our top priority; we aim for excellence in every interaction.</p>
    </div>
    <div class="value-card">
      <i class="fa fa-gem"></i>
      <h4>Quality & Style</h4>
      <p>Every product is crafted to meet the highest standards in style and quality.</p>
    </div>
  </div>
</section>

{{-- ===== Founders / Team ===== --}}
<section class="section fade-up">
  <h2>Meet Our Founders</h2>
  <div class="team">
    <div class="team-member">
      <img src="{{ asset('image/founder1.jpg') }}" alt="Fatima B.">
      <h4>Fatima B.</h4>
      <p>Co-Founder & CEO</p>
    </div>
    <div class="team-member">
      <img src="{{ asset('image/FATIMAN.jpg') }}" alt="Fatima N.">
      <h4>Fatima N.</h4>
      <p>Co-Founder & Creative Director</p>
    </div>
  </div>
</section>

{{-- ===== Footer ===== --}}
<footer class="shein-footer">
  <div class="footer-top">
    <div class="footer-column">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="#categories">Categories</a></li>
        <li><a href="#sellers">Sellers</a></li>
        <li><a href="#about">About</a></li>
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
  <div class="footer-payment">
    <h4>Payment Methods</h4>
    <div class="payment-icons">
      <img src="{{asset('image/visa.jpg')}}" alt="Visa">
      <img src="{{asset('image/paypal.jpg')}}" alt="PayPal">
      <img src="{{asset('image/omt.webp')}}" alt="OMT">
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2025 Beiroutique. All Rights Reserved.</p>
  </div>
</footer>

{{-- ===== JS for Scroll Animation ===== --}}
<script>
  function animateOnScroll() {
    const elements = document.querySelectorAll('.fade-up, .value-card');
    const triggerBottom = window.innerHeight * 0.85;
    elements.forEach(el => {
      const rect = el.getBoundingClientRect();
      if(rect.top < triggerBottom){
        el.classList.add('active');
      }
    });
  }
  window.addEventListener('scroll', animateOnScroll);
  window.addEventListener('load', animateOnScroll);
</script>

</body>
</html>





