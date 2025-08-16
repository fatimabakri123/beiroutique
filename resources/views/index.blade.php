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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
  <nav class="navbar-main" role="navigation" aria-label="Main navigation">
    <div class="logo">
      <img src="{{ asset('image/beiroutique.png') }}" alt="Logo" width="50" height="50">
    </div>

    <form class="search-container" role="search" action="{{ url('/search') }}" method="GET">
      <input
        type="search"
        name="q"
        placeholder="Search for products, brands and more..."
        aria-label="Search"
      />
      <button type="submit" aria-label="Submit search">
        <i class="fa fa-search"></i>
      </button>
    </form>

    <div class="nav-icons" role="navigation" aria-label="User navigation">
      <a href="#" aria-label="Account">
        <i class="fa-regular fa-user"></i>
      </a>
      <a href="/favorites" aria-label="Favorites" class="favorites">
        <i class="fa fa-heart"></i>
      </a>
      <a href="/cart" aria-label="Cart">
        <i class="fa fa-shopping-cart"></i>
      </a>
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
<!-- ====== Categories Section ====== -->
<section class="categories-section" style="padding: 30px; background-color: #fff;">
    
    <div class="categories-container" style="display: flex; overflow-x: auto; gap: 15px; scrollbar-width: thin;">
        <div class="category-card">
            <img src="{{ asset('image/women.jpg') }}" alt="Women" />
            <p>Women</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/men.jpg') }}" alt="Men" />
            <p>Men</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/kids.jpg') }}" alt="Kids" />
            <p>Kids</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/shoes.jpg') }}" alt="Shoes" />
            <p>Shoes</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/accessories.jpg') }}" alt="Accessories" />
            <p>Accessories</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/home.jpg') }}" alt="Home & Kitchen" />
            <p>Home & Kitchen</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/beauty.jpg') }}" alt="Beauty" />
            <p>Beauty</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/sports.jpg') }}" alt="Sports" />
            <p>Sports</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/bags.jpg') }}" alt="Bags & Luggage" />
            <p>Bags & Luggage</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/cellphone.jpg') }}" alt="Cell Phone Accessories" />
            <p>Cell Phone Accessories</p>
        </div>
        <div class="category-card">
            <img src="{{ asset('image/stationary.jpg') }}" alt="Stationary" />
            <p>Stationary</p>
        </div>
</section>
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
</section>

<section class="community-stats" aria-labelledby="section-heading">
  <p class="subtitle">Products loved by other users</p>

  <div class="stats-grid">
    <div class="stat-card" data-users="120" role="listitem">
      <div class="card-inner">
        <img src="{{ asset('image/dress.jpg') }}" alt="A stylish, flowy dress in a vibrant color, loved by 120 users" />
        <div class="feedback-carousel" aria-live="polite">
          <div class="feedback-item">
            <p>"<span class="user-name">Sarah</span>- It is a very good dress. Great fit and comfortable fabric!"</p>
          </div>
          <div class="feedback-item">
            <p>"<span class="user-name">Maria</span>- Beautiful design and good quality. Sizes run small though."</p>
          </div>
        </div>
        <div class="bar-container" title="120 users">
          <div class="bar"></div>
          <span class="bar-label">0%</span>
        </div>
        <span class="users-count" aria-live="polite">0 users</span>
      </div>
    </div>

    <div class="stat-card" data-users="200" role="listitem">
      <div class="card-inner">
        <img src="{{ asset('image/tshirt.jpg') }}" alt="A soft, comfortable t-shirt with multiple color options, a community pick" />
        <div class="feedback-carousel" aria-live="polite">
          <div class="feedback-item">
            <p>"<span class="user-name">John</span>- I love this t-shirt. Soft material and true to size."</p>
          </div>
          <div class="feedback-item">
            <p>"<span class="user-name">Liam</span>- Great colors and fabric quality. Limited color options though."</p>
          </div>
        </div>
        <div class="bar-container" title="200 users">
          <div class="bar"></div>
          <span class="bar-label">0%</span>
        </div>
        <span class="users-count" aria-live="polite">0 users</span>
      </div>
    </div>
    <div class="stat-card" data-users="200" role="listitem">
      <div class="card-inner">
        <img src="{{ asset('image/cover-phone.jpg') }}" alt="A soft, comfortable t-shirt with multiple color options, a community pick" />
        <div class="feedback-carousel" aria-live="polite">
          <div class="feedback-item">
            <p>"<span class="user-name">Ali</span>- The cover is sleek and fits perfectly."</p>
          </div>
          <div class="feedback-item">
            <p>"<span class="user-name">Lama</span>- Great colors and fabric quality. Limited color options though."</p>
          </div>
        </div>
        <div class="bar-container" title="200 users">
          <div class="bar"></div>
          <span class="bar-label">0%</span>
        </div>
        <span class="users-count" aria-live="polite">0 users</span>
      </div>
    </div>
    <div class="stat-card" data-users="200" role="listitem">
      <div class="card-inner">
        <img src="{{ asset('image/home-kitchen.jpg') }}" alt="A sleek phone cover with vibrant colors, a community favorite" />
        <div class="feedback-carousel" aria-live="polite">
          <div class="feedback-item">
            <p>"<span class="user-name">Zeina</span>- I love the design and functionality of this kitchen gadget."</p>
          </div>
          <div class="feedback-item">
            <p>"<span class="user-name">Fatima</span>- It is so useful! I wish there were more color options though."</p>
          </div>
        </div>
        <div class="bar-container" title="200 users">
          <div class="bar"></div>
          <span class="bar-label">0%</span>
        </div>
        <span class="users-count" aria-live="polite">0 users</span>
      </div>
    </div>
    <div class="stat-card" data-users="200" role="listitem">
      <div class="card-inner">
        <img src="{{ asset('image/earphone.jpg') }}" alt="A sleek phone cover with vibrant colors, a community favorite" />
        <div class="feedback-carousel" aria-live="polite">
          <div class="feedback-item">
            <p>"<span class="user-name">Omar</span>- The sound quality is amazing and they are very comfortable."</p>
          </div>
          <div class="feedback-item">
            <p>"<span class="user-name">Hana</span>- Great value for money. I wish the battery life was longer."</p>
          </div>
        </div>
        <div class="bar-container" title="200 users">
          <div class="bar"></div>
          <span class="bar-label">0%</span>
        </div>
        <span class="users-count" aria-live="polite">0 users</span>
      </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.stat-card');
  const usersArray = Array.from(cards).map(c => parseInt(c.dataset.users));
  const maxUsers = Math.max(...usersArray);

  cards.forEach((card, index) => {
    const users = parseInt(card.dataset.users);
    const bar = card.querySelector('.bar');
    const label = card.querySelector('.bar-label');
    const usersCount = card.querySelector('.users-count');
    const percent = Math.round((users / maxUsers) * 100);

    // Animate the bar width with a delay
    setTimeout(() => {
      bar.style.width = `${percent}%`;
    }, index * 200 + 100); // Small delay to sync with other animations

    // Animate the label and number count
    let count = 0;
    const step = Math.ceil(users / 50);
    const countInterval = setInterval(() => {
      if (count >= users) {
        clearInterval(countInterval);
        count = users;
      } else {
        count += step;
      }
      usersCount.textContent = `${count} users`;
      label.textContent = `${percent}%`;
    }, 20 + index * 10);

    // Feedback carousel logic
    const feedbacks = card.querySelectorAll('.feedback-item');
    if (feedbacks.length > 1) {
      let currentFeedbackIndex = 0;
      feedbacks[currentFeedbackIndex].style.opacity = 1;

      setInterval(() => {
        feedbacks[currentFeedbackIndex].style.opacity = 0;
        currentFeedbackIndex = (currentFeedbackIndex + 1) % feedbacks.length;
        feedbacks[currentFeedbackIndex].style.opacity = 1;
      }, 3000);
    } else if (feedbacks.length === 1) {
      feedbacks[0].style.opacity = 1;
    }
  });
});
</script>


<!-- ====== SHEIN Style Footer - Brown & Beige + Payment ====== -->
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