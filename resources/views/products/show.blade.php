<style>
/* ===== PRODUCT PAGE ===== */
/* ===== PRODUCT PAGE ===== */
:root {
    --purple-dark: #5b2a86;
    --purple-soft: #1f7bb8eb;
    --blue-soft: #8f3f9beb;

    --bg-light: #fdfcff;
    --white: #ffffff;

    --text-dark: #1e1b4b;
    --text-muted: #6b7280;

    --border-soft: rgba(226,232,240,0.8);
    --shadow-soft: 0 18px 40px rgba(91, 42, 134, 0.18);

    --radius: 15px;
}

/* ===== PRODUCT PAGE CONTAINER ===== */
.product-page {
    max-width: 1000px; /* smaller */
    margin: 40px auto;
    display: flex;
    flex-direction: column;
    gap: 25px;
    color: var(--text-dark);
    background: var(--bg-light);
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
}

/* ===== PRODUCT TOP ===== */
.product-top {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: flex-start;
    background: var(--white);
    border-radius: var(--radius);
    padding: 18px; /* smaller */
    box-shadow: var(--shadow-soft);
}

/* IMAGE */
.product-image {
    flex: 1;
    min-width: 260px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.product-image img {
    width: 100%;
    max-width: 320px; /* smaller */
    border-radius: var(--radius);
    box-shadow: var(--shadow-soft);
    transition: transform 0.3s ease;
}

.product-image img:hover {
    transform: scale(1.03);
}

/* SHOP */
.product-image .shop-name {
    font-weight: 700;
    color: var(--purple-dark);
    font-size: 14px;
}

.shop-btn {
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: var(--white);
    padding: 8px 14px;
    border-radius: var(--radius);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

/* INFO */
.product-info {
    flex: 1;
    min-width: 260px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.product-info h2 {
    font-size: 25px;
    color: var(--purple-dark);
}

.product-info p {
    font-size: 20px;
    color: var(--text-muted);
    line-height: 1.5;
}

.product-info h4 {
    font-size: 18px;
    color: var(--text-dark);
}

/* OPTIONS */
.options {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
}

.color-option {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid var(--border-soft);
    cursor: pointer;
}

.size-option {
    padding: 6px 10px;
    border: 1px solid var(--border-soft);
    border-radius: var(--radius);
    cursor: pointer;
    font-weight: 500;
    font-size: 16px;
}

input[type="radio"]:checked + label {
    outline: 2px solid var(--purple-dark);
}

/* BUTTONS */
.btn.primary {
     background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: var(--white);
    padding: 9px 14px;
    border: none;
    border-radius: var(--radius);
    cursor: pointer;
    font-weight: 600;
    font-size: 18px;
}

.btn.primary:hover {
    background: var(--purple-soft);
}

.btn-danger {
    background: #e74c3c;
    color: var(--white);
    border: none;
    padding: 6px 12px;
    border-radius: var(--radius);
}

/* ===== REVIEWS ===== */
.product-reviews {
    background: var(--white);
    padding: 25px;
    border-radius: 18px;
    box-shadow: var(--shadow-soft);
}

.product-reviews h3 {
    font-size: 18px;
    color: var(--purple-dark);
    cursor: pointer;
}

.reviews-container {
    display: none;
    flex-direction: column;
    gap: 18px;
    margin-top: 15px;
}

.review-box {
    background: #f9fafb;
    border: 1px solid rgba(226,232,240,0.9);
    border-radius: 16px;
    padding: 16px;
}

.review-name {
    font-size: 14px;
    font-weight: 600;
}

.review-text {
    font-size: 13px;
    color: #374151;
}

.view-more {
    background: none;
    border: none;
    color: var(--purple-dark);
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .product-top {
        flex-direction: column;
        align-items: center;
    }
}

</style>
<!-- NAVBAR -->
 <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<nav class="product-navbar">
    <div class="nav-container">
        <a href="{{ route('customer.profile') }}" class="nav-icon">
            <i class="fa fa-user fa-lg"></i>
        </a>

        <a href="{{ route('customer.wishlist') }}" class="nav-icon">
            <i class="fa fa-heart fa-lg"></i>
            
        </a>

        <a href="{{ route('customer.cart') }}" class="nav-icon">
            <i class="fa fa-shopping-cart fa-lg"></i>
           
        </a>
    </div>
</nav>

<style>
.product-navbar {
    width: 100%;
    background: var(--white);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 10px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.product-navbar .nav-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    gap: 25px;
    padding: 0 15px;
}

.product-navbar .nav-icon {
    position: relative;
    color: var(--purple-dark);
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    padding: 8px;
    transition: all 0.3s;
}

.product-navbar .nav-icon:hover {
    color: var(--purple-soft);
    transform: scale(1.1);
}

/* BADGE */
.product-navbar .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #e74c3c;
    color: #fff;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 50%;
    line-height: 1;
}

@media (max-width: 900px) {
    .product-navbar .nav-container {
        justify-content: center;
        gap: 15px;
    }
}

/* PRODUCT IMAGE SLIDER */
.product-slider {
    position: relative;
    width: 100%;
    max-width: 400px;
}

.product-slider-img {
    width: 100%;
    border-radius: var(--radius);
    box-shadow: var(--shadow-soft);
    display: none;
    transition: transform 0.3s ease;
}

.product-slider-img.active {
    display: block;
}

/* ARROWS */
.product-slider .slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.9);
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    color: var(--purple-dark);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.product-slider .prev { left: -15px; }
.product-slider .next { right: -15px; }

.product-slider .slider-btn:hover {
    background: #fff;
    transform: translateY(-50%) scale(1.1);
}

</style>


<style>
.product-navbar {
    width: 100%;
    background: var(--white);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 10px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.product-navbar .nav-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    gap: 25px;
    padding: 0 15px;
}

.product-navbar .nav-link {
    text-decoration: none;
    color: var(--purple-dark);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    position: relative;
    transition: all 0.3s;
}

.product-navbar .nav-link:hover {
    color: var(--purple-soft);
}

/* BADGE */
.product-navbar .badge {
    position: absolute;
    top: -5px;
    right: -10px;
    background: #e74c3c;
    color: #fff;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 50%;
    line-height: 1;
}

@media (max-width: 900px) {
    .product-navbar .nav-container {
        justify-content: center;
        gap: 15px;
    }
}

/* SAME SIZE FOR EDIT & DELETE */
.review-actions button {
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 10px;
    line-height: 1.2;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* EDIT */
.review-actions .btn-edit {
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: #fff;
    border: none;
}

/* DELETE */
.review-actions .btn-danger {
    background: #ef4444;
    color: #fff;
    border: none;
}
 /* BIGGER SHOP NAME + BUTTON */
.product-image .shop-name {
    font-size: 18px !important;
    font-weight: 800 !important;
    color: var(--purple-dark);
    display: block;
    margin-top: 12px;
}

.product-image .shop-name + span {
    font-size: 13px;
    color: var(--text-muted);
}

.shop-btn {
    margin-top: 8px;
    padding: 11px 22px !important;
    font-size: 18px !important;
    border-radius: 18px !important;
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
}
     
            .review-page { 
    padding: 20px 40px; 
    min-height: 100vh; 
    background: linear-gradient(135deg, #fdfcff, #f6f0ff);
}

/* ===== TITLE ===== */
.review-title { text-align: center; font-size: 28px; margin-bottom: 20px; color: #333; }

/* ===== HEADER (TABLE-LIKE) ===== */
.review-table-header{
    display:grid;
    grid-template-columns: 180px 1fr 120px 140px 140px;
    gap:20px;
    padding:12px 20px;
    margin-bottom:10px;
    font-weight:700;
    color:#555;
}

/* ===== LIST ===== */
.review-list{ display:flex; flex-direction:column; gap:15px; }

/* ===== CARD (GRID) ===== */
.review-card{
    display:grid;
    grid-template-columns: 180px 1fr 120px 140px 140px;
    gap:20px;
    background:#fff;
    padding:20px;
    border-radius:18px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
    border-left:5px solid transparent;
    align-items:center;
    transition:.3s;
}
.review-card:hover{
    transform:translateY(-4px);
    box-shadow:0 8px 30px rgba(0,0,0,.15);
    border-left-color:#5b93c7;
}
/* Smaller text inside the review textarea */
.add-review-card .add-review-form textarea {
    font-size: 18px; /* make text smaller */
    line-height: 1.4; /* optional: better spacing */
    color: #333; /* text color */
    font-family: 'Poppins', sans-serif; /* match font */
}


/* ===== PRODUCT ===== */
.review-header{
    display:flex; flex-direction:column; align-items:center; gap:8px; text-align:center;
}
.review-header img{
    width:80px; height:80px; object-fit:cover; border-radius:10px; border:2px solid #ccc;
}
.review-header h4{ font-size:14px; margin:0; }

/* ===== CONTENT AS GRID CELLS ===== */
.review-content{ display:contents; }
.review-text{ grid-column:2; color:#555; }
.rating{ grid-column:3; text-align:center; color:#facc15; font-size:1.8em; }
.review-image{ grid-column:4; width:90px; height:90px; object-fit:cover; border-radius:10px; border:2px solid #ccc; margin:auto; }
.no-img{ grid-column:4; text-align:center; color:#999; }
.review-actions{ grid-column:5; display:flex; gap:8px; justify-content:center; }

/* ===== EDIT FORM ===== */
.edit-form{ grid-column:2 / span 4; margin-top:10px; }
.edit-form textarea,.edit-form select,.edit-form input{
    width:100%; margin-bottom:8px; padding:6px 10px; border-radius:8px; border:1px solid #ccc;
}
.edit-actions{ display:flex; gap:8px; }

/* ===== ADD REVIEW CARD ===== */
.add-review-card { grid-template-columns: 1fr; }
.add-review-card .add-review-form label { display:block; margin:10px 0 5px; font-weight:600; color:#555; }
.add-review-card .add-review-form select,
.add-review-card .add-review-form textarea,
.add-review-card .add-review-form input[type="file"] {
    width:100%; padding:8px 12px; border-radius:8px; border:1px solid #ccc; margin-bottom:10px;
}
.add-review-card .btn.primary { width:100%; padding:12px; background:linear-gradient(135deg,#8f3f9b,#1f7bb8,#5b2a86); color:#fff; border:none; border-radius:8px; font-size:16px; cursor:pointer; transition:0.3s; }
.add-review-card .btn.primary:hover{opacity:.9;}

/* ===== STARS ===== */
.star-rating { display:flex; gap:10px; font-size:2.2em; margin-bottom:10px; }
.star-rating .star { cursor:pointer; color:#ccc; transition:color 0.2s; }
.star-rating .star.filled { color:gold; }

/* ===== BUTTONS ===== */
.submit-btn{background:#4caf50;color:#fff;}
.cancel-btn,.delete-btn{background:#f44336;color:#fff;}
.edit-btn{ background: linear-gradient(135deg, #a080bc, #5b93c7);color:#fff;}
.submit-btn,.cancel-btn,.edit-btn,.delete-btn{
    border:none; padding:6px 12px; border-radius:8px; cursor:pointer;font-size:16px;
}

/* ===== EMPTY ===== */
.no-reviews{ text-align:center; color:#999; margin-top:30px; }

/* ===== MOBILE ===== */
@media(max-width:900px){
    .review-table-header{ display:none; }
    .review-card{ grid-template-columns:1fr; }
    .review-header,.review-text,.rating,.review-image,.review-actions,.edit-form{ grid-column:auto; text-align:left; }
}
</style>



<div class="product-page">

    <!-- PRODUCT TOP -->
    <div class="product-top">

        <!-- IMAGE -->
      <div class="product-image">

    @php
        $images = $product->images && $product->images->count()
            ? $product->images
            : collect([(object)['image_path' => $product->image_url]]);
    @endphp

    <div class="product-slider" data-index="0">
        @foreach($images as $img)
            <img
                src="{{ Str::startsWith($img->image_path, 'products/')
                    ? asset('storage/' . $img->image_path)
                    : asset($img->image_path) }}"
                class="product-slider-img"
                alt="{{ $product->product_name }}">
        @endforeach

        @if($images->count() > 1)
            <button class="slider-btn prev">❮</button>
            <button class="slider-btn next">❯</button>
        @endif
    </div>

    <span class="shop-name">{{ $product->shop->shop_name }}</span> Shop sells this item
    <a href="{{ route('shop.products', $product->shop->shop_id) }}" class="btn shop-btn">
        Visit Shop
    </a>
</div>


        <!-- INFO -->
        <div class="product-info">
            <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                @csrf

                <h2>{{ $product->product_name }}</h2>
                <p>{{ $product->description }}</p>
                <p>{{ $product->stock_quantity }}</p>

                @if($product->is_on_sale)
                    <p>
                        <strong>Price:</strong>
                        <span style="color:red; font-weight:bold;">${{ number_format($product->discount_value, 2) }}</span><br>
                        <small style="text-decoration: line-through; color:#999;">${{ number_format($product->price, 2) }}</small>
                    </p>
                @else
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                @endif

                {{-- COLORS --}}
                @if(!empty($product->color))
                    <h4>Choose Color</h4>
                    <div class="options">
                        @php
                            $colors = is_array($product->color) ? $product->color : (str_starts_with($product->color,'[') ? json_decode($product->color,true) : explode(',', $product->color));
                        @endphp
                       @foreach($colors as $i => $color)
    @php
        $color = trim($color);

        // Fix common typos
        $colorLower = strtolower($color);
        if($colorLower == 'balck') $color = 'black';
        if($colorLower == 'greeen') $color = 'green';

        // default border
        $borderColor = '#888';

        if(str_starts_with($color, '#')){
            // HEX colors
            $hex = str_replace('#','',$color);
            if(strlen($hex) == 3){
                $r = hexdec(str_repeat(substr($hex,0,1),2));
                $g = hexdec(str_repeat(substr($hex,1,1),2));
                $b = hexdec(str_repeat(substr($hex,2,1),2));
            } else {
                $r = hexdec(substr($hex,0,2));
                $g = hexdec(substr($hex,2,2));
                $b = hexdec(substr($hex,4,2));
            }
            $brightness = ($r*299 + $g*587 + $b*114)/1000;
            $borderColor = $brightness > 200 ? '#444' : '#fff';
        } else {
            // Named colors
            if($colorLower == 'white') $borderColor = '#444';
            elseif($colorLower == 'black') $borderColor = '#fff';
            else $borderColor = '#888';
        }
    @endphp

    <input type="radio" id="color{{ $i }}" name="selected_color" value="{{ $color }}" hidden required>
    <label for="color{{ $i }}" class="color-option"
           style="background-color: {{ $color }}; border: 2px solid {{ $borderColor }};"
           title="{{ $color }}">
    </label>
@endforeach

                    </div>
                @endif

                {{-- SIZES --}}
                @if(!empty($product->size))
                    <h4>Choose Size</h4>
                    <div class="options">
                        @php
                            $sizes = is_array($product->size) ? $product->size : (str_starts_with($product->size,'[') ? json_decode($product->size,true) : explode(',', $product->size));
                        @endphp
                        @foreach($sizes as $i => $size)
                            @php $size = trim($size); @endphp
                            <input type="radio" id="size{{ $i }}" name="selected_size" value="{{ $size }}" hidden required>
                            <label for="size{{ $i }}" class="size-option">{{ $size }}</label>
                        @endforeach
                    </div>
                @endif

                {{-- ERRORS --}}
                @if(session('error'))
                    <p style="color:#c0392b; margin-top:10px;">{{ session('error') }}</p>
                @endif

                <button class="btn primary" type="submit" onclick="return animateAddToCart(event)">
    Add to Cart
</button>


            </form>

            <button class="btn primary" onclick="buyNowCheck()">Buy Now</button>
        </div>

    </div>




<!-- ADD REVIEW FORM -->
<div class="product-reviews" id="reviews">

    <h3>Add a Review</h3>
    <div class="review-card add-review-card">
        <form action="{{ route('reviews.store', $product->product_id) }}" method="POST" enctype="multipart/form-data" class="add-review-form">
         
           @csrf

            <!-- Comment -->
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" rows="3" placeholder="Write your review..." required></textarea>

            <!-- Rating Stars -->
            <label>Rating:</label>
            <div class="star-rating" id="new-review-stars">
                @for($i=1; $i<=5; $i++)
                    <span class="star" data-value="{{ $i }}">&#9733;</span>
                @endfor
            </div>
            <input type="hidden" name="rating" id="new-review-rating" value="0">

            <!-- Image Upload -->
            <label for="image">Upload Image (optional):</label>
            <input type="file" name="image" accept="image/*">
        <button class="btn primary" style="margin-top:10px">Submit Review</button>
 
    </form>
</div>

    <!-- REVIEW LIST -->
    <h3>Reviews</h3>
    <div class="reviews-container">
        @if($reviews->count())
            @foreach($reviews as $review)
                <div class="review-box">
                    <!-- Edit & Delete Buttons -->
                    <div class="review-actions">
                        @if(auth()->check() && auth()->id() === $review->customer?->user_id)
                            <button class="btn-edit" onclick="toggleEdit({{ $review->review_id }})">
                                <i class="fa fa-pen"></i>
                            </button>
                            <form action="{{ route('reviews.destroy', $review->review_id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Review Content -->
                    <div class="review-content">
                        <div class="review-text-container">
                            <strong class="review-name">{{ $review->customer?->user?->name ?? 'Unknown' }}</strong>
                            <div class="review-rating">⭐ {{ $review->rating }}/5</div>
                            <span class="review-text">{{ $review->comment }}</span>
                        </div>

                        @if($review->image)
                            <img src="{{ asset('storage/' . $review->image) }}" class="review-image" onclick="zoomImage(this)">
                        @endif
                    </div>

                    <!-- Edit Form -->
                    @if(auth()->check() && auth()->id() === $review->customer?->user_id)
                        <form action="{{ route('reviews.update', $review->review_id) }}" method="POST" enctype="multipart/form-data" class="edit-form" id="edit-form-{{ $review->review_id }}" style="display:none">
                            @csrf
                            @method('PUT')
                            <label>Rating</label>
                            <select name="rating">
                                @for($i=1;$i<=5;$i++)
                                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>

                            <label>Comment</label>
                            <textarea name="comment">{{ $review->comment }}</textarea>

                            <label>Change Image</label>
                            <input type="file" name="image">

                            <button class="btn primary" style="margin-top:8px">Save Changes</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @else
            <p>No reviews yet.</p>
        @endif
    </div>

    <!-- Pagination -->
<!-- Pagination Links بدون onclick -->
<div class="reviews-pagination">
    @if ($reviews->onFirstPage())
        <span class="page disabled">&lt;</span>
    @else
        <a href="{{ $reviews->previousPageUrl() }}#reviews" class="page">&lt;</a>
    @endif

    @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
        @if ($page == $reviews->currentPage())
            <span class="page current">{{ $page }}</span>
        @else
            <a href="{{ $url }}#reviews" class="page">{{ $page }}</a>
        @endif
    @endforeach

    @if ($reviews->hasMorePages())
        <a href="{{ $reviews->nextPageUrl() }}#reviews" class="page">&gt;</a>
    @else
        <span class="page disabled">&gt;</span>
    @endif
</div>

</div>





      
    <h3>You may also like</h3>
<div class="grid">
    <style>
        .reviews-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.reviews-pagination .page {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 6px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #5b2a86;
    font-weight: 600;
    font-size: 14px;
}

.reviews-pagination .page.current {
    background-color: #5b2a86;
    color: #fff;
    border-color: #5b2a86;
}

.reviews-pagination .page.disabled {
    color: #999;
    border-color: #ccc;
    cursor: not-allowed;
}

        /* ===== RECOMMENDATION GRID ===== */
.grid{
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 18px;
    margin-top: 20px;
}

.card{
    background: #fff;
    border-radius: 14px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: all .3s ease;
    cursor: pointer;
}

.card:hover{
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.card img{
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

.card p{
    font-size: 14px;
    font-weight: 600;
    margin: 8px 0 4px;
    color: #222;
    line-height: 1.3;
}

.card span{
    font-size: 15px;
    font-weight: bold;
    color: #6b21a8; /* purple */
}

/* REVIEW CARD */
.review-box {
    background: #f9fafb;
    border: 1px solid rgba(226,232,240,0.9);
    border-radius: 18px;
    padding: 20px 22px;
    position: relative; /* for top-right buttons */
    display: flex;
    gap: 15px;
    transition: all 0.3s ease;
}

.review-box:hover {
    background: #ffffff;
    transform: translateY(-4px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.08);
}

/* EDIT & DELETE ICONS */
.review-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    gap: 8px;
}

.review-actions button {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 16px;
}

.btn-edit {
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: #fff;
}

.btn-edit:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(91,42,134,0.35);
}

.btn-danger {
    background: #ef4444;
    color: #fff;
}

.btn-danger:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(237,76,60,0.35);
}

/* REVIEW CONTENT */
.review-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* NAME + STARS */
.review-name {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
}

.review-rating {
    font-size: 14px;
    font-weight: 700;
    color: #f59e0b;
    margin-top: 4px;
}

/* REVIEW TEXT */
.review-text {
    font-size: 16px;
    line-height: 1.8;
    color: #374151;
}

/* REVIEW IMAGE */
.review-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
    margin-left: 15px;
    border: 1px solid rgba(0,0,0,0.08);
    cursor: zoom-in;
    flex-shrink: 0;
}

/* REVIEW CARD */
.review-box {
    background: #f9fafb;
    border: 1px solid rgba(226,232,240,0.9);
    border-radius: 18px;
    padding: 20px 22px;
    position: relative;
    display: flex;
    gap: 15px;
    transition: all 0.3s ease;
}

.review-box:hover {
    background: #ffffff;
    transform: translateY(-4px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.08);
}

/* EDIT & DELETE ICONS */
.review-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    gap: 8px;
}

.review-actions button {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 16px;
}

.btn-edit {
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: #fff;
}

.btn-edit:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(91,42,134,0.35);
}

.btn-danger {
    background: #ef4444;
    color: #fff;
}

.btn-danger:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(237,76,60,0.35);
}

/* FLEX CONTAINER FOR TEXT + IMAGE */
.review-content {
    flex: 1;
    display: flex;
    gap: 15px;
}

/* TEXT CONTAINER */
.review-text-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* NAME + STARS */
.review-name {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

.review-rating {
    font-size: 15px;
    font-weight: 700;
    color: #f59e0b;
    margin-top: 4px;
}

/* REVIEW TEXT */
.review-text {
    font-size: 22px; /* bigger text */
    line-height: 1.8;
    color: #374151;
}

/* REVIEW IMAGE */
.review-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.08);
    cursor: zoom-in;
    flex-shrink: 0;
    align-self: flex-start; /* aligns to top of text */
}

.reviews-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.reviews-pagination {
    display: flex;
    justify-content: center;
    margin-top: 15px;
}
.cart-bounce {
    animation: bounce 0.5s;
}
@keyframes bounce {
    0% { transform: scale(1); }
    30% { transform: scale(1.3); }
    60% { transform: scale(0.9); }
    100% { transform: scale(1); }
}

</style>
@if($recommendations->count())
    <div class="recommendations-section">
        <h3>You may also like</h3>
        <div class="grid">
            @foreach($recommendations as $item)
                <div class="card" onclick="window.location='{{ route('product.show', $item->product_id) }}'">
                    @if($item->images->first())
                        <img src="{{ asset('storage/'.$item->images->first()->image_path) }}" alt="{{ $item->product_name }}">
                    @else
                        <img src="{{ asset('storage/'.$item->image_url) }}" alt="{{ $item->product_name }}">
                    @endif
                    <p>{{ Str::limit($item->product_name, 40) }}</p>
                    @if($item->is_on_sale)
                        <span style="color:red; font-weight:bold;">${{ number_format($item->discount_value, 2) }}</span>
                        <small style="text-decoration: line-through; color:#999;">${{ number_format($item->price, 2) }}</small>
                    @else
                        <span>${{ number_format($item->price, 2) }}</span>

                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function isLoggedIn() {
    return {{ auth()->check() ? 'true' : 'false' }};
}

function showAlert(title, text, icon = 'warning') {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'OK',
        confirmButtonColor: '#5b2a86',
        background: '#ffffff',
        color: '#1f7bb8',
        iconColor: '#5b2a86',

        width: '300px',     
        padding: '0.7rem', 
        heightAuto: true,

        customClass: {
            title: 'swal-title-theme',
            htmlContainer: 'swal-content-theme',
            popup: 'swal-popup-theme',
            confirmButton: 'swal-btn-theme'
        }
    });
}


function checkOptions() {
    const colorRequired = document.querySelector('input[name="selected_color"]');
    const sizeRequired  = document.querySelector('input[name="selected_size"]');

    if (colorRequired && !document.querySelector('input[name="selected_color"]:checked')) {
        showAlert('Missing Color', 'Please choose a color first');
        return false;
    }
    if (sizeRequired && !document.querySelector('input[name="selected_size"]:checked')) {
        showAlert('Missing Size', 'Please choose a size first');
        return false;
    }
    return true;
}

function checkAuthAndOptions() {
    if (!isLoggedIn()) {
      
        localStorage.setItem('redirectAfterLogin', window.location.href);
        
        
        const redirectUrl = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.href);
        
        showAlert('Login Required', 'Please login to continue', 'info');
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 1500);
        return false;
    }
    return checkOptions();
}

function buyNowCheck() {
    if (!isLoggedIn()) {
       
        localStorage.setItem('redirectAfterLogin', window.location.href);
        
        
        const redirectUrl = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.href);
        
        showAlert('Login Required', 'Please login to continue', 'info');
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 1500);
        return;
    }
    
    window.location.href = "{{ route('checkout.now', $product->product_id) }}";
}
function toggleReviewsHeader() {
    const container = document.querySelector('.reviews-container');
    if (container.style.display === 'flex') {
        container.style.display = 'none';
    } else {
        container.style.display = 'flex';
    }
}

function toggleEdit(id) {
    const form = document.getElementById('edit-form-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleReviews(btn) {
    document.querySelectorAll('.extra-review').forEach(r => r.classList.toggle('hidden'));
    btn.textContent = btn.textContent === 'View more reviews' ? 'Show less' : 'View more reviews';
}
document.querySelectorAll('.product-slider').forEach(slider => {
    const images = slider.querySelectorAll('.product-slider-img');
    if (!images.length) return;

    let index = 0;
    images[index].classList.add('active');

    const prev = slider.querySelector('.prev');
    const next = slider.querySelector('.next');

    function showImage(i) {
        images.forEach(img => img.classList.remove('active'));
        images[i].classList.add('active');
    }

    prev?.addEventListener('click', e => {
        e.preventDefault();
        index = (index - 1 + images.length) % images.length;
        showImage(index);
    });

    next?.addEventListener('click', e => {
        e.preventDefault();
        index = (index + 1) % images.length;
        showImage(index);
    });
});
function animateAddToCart(e) {
    e.preventDefault();

    if (!isLoggedIn()) {
    localStorage.setItem('redirectAfterLogin', window.location.href);

    const redirectUrl = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.href);

    showAlert('Login Required', 'Please login to continue', 'info');

    setTimeout(() => {
        window.location.href = redirectUrl;
    }, 1500);

    return false;
}


    if (!checkOptions()) return false;

    const img = document.querySelector('.product-slider-img.active');
    const cartIcon = document.querySelector('.fa-shopping-cart').parentElement;

    const imgRect = img.getBoundingClientRect();
    const cartRect = cartIcon.getBoundingClientRect();

    const clone = img.cloneNode(true);
    clone.style.position = 'fixed';
    clone.style.left = imgRect.left + 'px';
    clone.style.top = imgRect.top + 'px';
    clone.style.width = imgRect.width + 'px';
    clone.style.height = imgRect.height + 'px';
    clone.style.transition = 'all 0.8s ease-in-out';
    clone.style.zIndex = 9999;

    document.body.appendChild(clone);

    setTimeout(() => {
        clone.style.left = cartRect.left + 'px';
        clone.style.top = cartRect.top + 'px';
        clone.style.width = '20px';
        clone.style.height = '20px';
        clone.style.opacity = '0.2';
    }, 10);

    setTimeout(() => {
        clone.remove();

        
        const form = e.target.closest('form');

        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        });

     
        cartIcon.classList.add('cart-bounce');
        setTimeout(() => cartIcon.classList.remove('cart-bounce'), 500);

        
    }, 850);

    return false;
}
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll("#new-review-stars .star");
    const ratingInput = document.getElementById("new-review-rating");

    stars.forEach(star => {
        star.addEventListener("click", function () {
            const value = this.getAttribute("data-value");
            ratingInput.value = value;

            // fill stars
            stars.forEach(s => {
                if (s.getAttribute("data-value") <= value) {
                    s.classList.add("filled");
                } else {
                    s.classList.remove("filled");
                }
            });
        });
    });
});
</script>