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
  <!-- Main Navbar -->
  <nav class="navbar-main" role="navigation" aria-label="Main navigation">
    <div class="logo">
      <img src="{{ asset('image/beiroutique.png') }}" alt="Logo" width="50" height="50">
    </div>

    <form class="search-container" role="search" action="{{ url('/search') }}" method="GET">
      <input type="search" name="q" placeholder="Search for products, brands and more..." aria-label="Search" />
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
      <!-- Filter Button inside navbar -->
      <div class="filter-toggle">
        <button onclick="document.getElementById('filterPanel').classList.toggle('open')">
          <i class="fa fa-filter"></i> Filter
        </button>
      </div>
    </div>
  </nav>

  <!-- Category Bar -->
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

  <!-- Filter Side Panel -->
  <div id="filterPanel" class="filter-panel">
    <div class="filter-header">
      <h3>Filter</h3>
      <button class="close-btn" onclick="document.getElementById('filterPanel').classList.remove('open')">
        <i class="fa fa-times"></i>
      </button>
    </div>
    <div class="filter-body">
      <div id="category">
        <h2>Category</h2>
        <label><input type="radio" name="category" value="women_dresses"> Women Dresses</label>
        <label><input type="radio" name="category" value="women_tops"> Women Tops</label>
        <label><input type="radio" name="category" value="women_pants"> Women Pants</label>
        <label><input type="radio" name="category" value="women_skirts"> Women Skirts</label>
        <label><input type="radio" name="category" value="women_suits"> Women Suits</label>
    </div>

     <h2> Price Range</h2>
      <label><input type="checkbox"> Under $50</label>
      <label><input type="checkbox"> $50 - $100</label>
      <label><input type="checkbox"> $100 - $200</label>
      <label><input type="checkbox"> Over $200</label>

      <h2>Size</h2>
       <label><input type="checkbox"> One size</label>
      <label><input type="checkbox"> Women XS</label>
      <label><input type="checkbox"> Women S</label>
      <label><input type="checkbox"> Women M</label>
      <label><input type="checkbox"> Women L</label>
      <label><input type="checkbox"> Women XL</label>

      <h2> Pattern Type</h2>
      <label><input type="checkbox"> Solid</label>
      <label><input type="checkbox"> Striped</label>
      <label><input type="checkbox"> Checked</label>
      <label><input type="checkbox"> Floral</label>
      <label><input type="checkbox"> Animal Print</label>

      <h2>Color</h2>
      <label><input type="checkbox"> Red</label>
      <label><input type="checkbox"> Blue</label>
      <label><input type="checkbox"> Green</label>
      <label><input type="checkbox"> Black</label>
      <label><input type="checkbox"> White</label>

      <h2>Brand</h2>
      <label><input type="checkbox"> Brand A</label>
      <label><input type="checkbox"> Brand B</label>
      <label><input type="checkbox"> Brand C</label>
      <label><input type="checkbox"> Brand D</label>

      <h2>Material</h2>
      <label><input type="checkbox"> Cotton</label>
      <label><input type="checkbox"> Polyester</label>
      <label><input type="checkbox"> Wool</label>
      <label><input type="checkbox"> Silk</label>

      <h2>Style</h2>
      <label><input type="checkbox"> Casual</label>
      <label><input type="checkbox"> Formal</label>
      <label><input type="checkbox"> Sporty</label>
      <label><input type="checkbox"> Vintage</label>
      <label><input type="checkbox"> Bohemian</label>
      <h2>Length</h2>
      <label><input type="checkbox"> Short</label>
      <label><input type="checkbox"> Midi</label>
      <label><input type="checkbox"> Long</label>
  </div>
  

</body>
</html>
