<style>
/* ===== PRODUCT PAGE ===== */
.product-page {
    max-width: 1200px;
    margin: 40px auto;
    display: flex;
    flex-direction: column;
    gap: 40px;
}

/* ===== PRODUCT TOP: IMAGE + INFO ===== */
.product-top {
    display: flex;
    gap: 130px;
    align-items: flex-start;
    flex-wrap: wrap; /* responsive */

}

.product-image img {
    width: 400px;
    height: 500px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.product-info {
    flex: 1;
}

.product-info h2 {
    font-size: 30px;
    margin-bottom: 15px;
    color: #703e0bec;
}

.product-info p {
    margin-bottom: 10px;
    font-size: 20px;
}

.product-info h4 {
    margin-top: 20px;
    margin-bottom: 10px;
    font-size: 20px;
}

/* COLORS & SIZES */
.options {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.color-option {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid #ddd;
    cursor: pointer;
    display: inline-block;
}

.size-option {
    padding: 8px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
}

input[type="radio"]:checked + label {
    outline: 3px solid #C08A56;
    transform: scale(1.05);
}

/* BUTTONS */
.btn.primary {
    background: #C08A56;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    font-size: 18px;
    margin-top: 10px;
    transition: all 0.3s ease;
}

.btn.primary:hover {
    background: #a87140;
    transform: translateY(-2px);
}

.btn-danger {
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 8px;
}

/* ===== REVIEWS ===== */
.product-reviews {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    width: 100%; /* full width under product */
}

.review-box {
    background:#f9f9f9;
    padding:10px;
    border-radius:12px;
    margin-bottom:15px;
    color:#333;
   

}

.review-box img {
    max-width: 120px;
    border-radius: 10px;
    margin-top: 8px;
}

.review-box.hidden {
    display: none;
}

.view-more {
    background: none;
    border: none;
    color: #C08A56;
    font-weight: bold;
    cursor: pointer;
    margin-bottom: 20px;
}

/* EDIT FORM */
.edit-form {
    margin-top: 10px;
    padding: 15px;
    background: #fdf5e6;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.edit-form input[type="file"],
.edit-form textarea,
.edit-form select {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    width: 100%;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
    .product-top {
        flex-direction: column;
        align-items: center;
    }

    .product-image img {
        width: 100%;
        height: auto;
    }

    .product-info {
        width: 100%;
    }
}
/* =====================
   SHOP INFO
===================== */
.shop-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff5e5;
    border-radius: 18px;
    padding: 12px 20px;
    margin-bottom: 18px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    font-size: 15px;
    font-weight: 500;
    color: #5a3d26;
    transition: 0.3s;
}

.shop-info:hover {
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}

.shop-name {
    font-weight: 700;
    color: #8b5e3c;
}

.shop-btn {
    background: linear-gradient(135deg,#8b5e3c,#6b4f33);
    color: #fff;
    padding: 8px 18px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.shop-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.25);
}

.shop-btn:active {
    transform: scale(0.97);
}


</style>

<div class="product-page">

    <!-- PRODUCT TOP -->
    <div class="product-top">

        <!-- IMAGE -->
        <div class="product-image">
            <img src="{{ Str::startsWith($product->image_url, 'products/')
                ? asset('storage/' . $product->image_url)
                : asset($product->image_url) }}"
                alt="{{ $product->product_name }}">
                   <span class="shop-name">{{ $product->shop->shop_name }}</span> Shop  sells this item
<a href="{{ route('shop.products', $product->shop->shop_id) }}" class="btn shop-btn">
    Visit Shop
</a>
        </div>
<!-- SHOP INFO -->


        <!-- INFO -->
        <div class="product-info">
            
           <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
    @csrf

    <h2>{{ $product->product_name }}</h2>
    <p>{{ $product->description }}</p>
    @if($product->is_on_sale)
    <p>
        <strong>Price:</strong>
        <span style="color:red; font-weight:bold;">
            ${{ number_format($product->discount_value, 2) }}
        </span>
        <br>
        <small style="text-decoration: line-through; color:#999;">
            ${{ number_format($product->price, 2) }}
        </small>
    </p>
@else
    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>

@endif


    {{-- COLORS --}}
 @if(!empty($product->color))
    <h4>Choose Color</h4>
    <div class="options">

        @php
            if (is_array($product->color)) {
                $colors = $product->color;
            } elseif (is_string($product->color) && str_starts_with($product->color, '[')) {
                $colors = json_decode($product->color, true);
            } else {
                $colors = explode(',', $product->color);
            }
        @endphp

        @foreach($colors as $i => $color)
            @php $color = trim($color); @endphp

            <input type="radio"
                   id="color{{ $i }}"
                   name="selected_color"
                   value="{{ $color }}"
                   hidden
                   required>

            <label for="color{{ $i }}"
                   class="color-option"
                   style="background-color: {{ $color }};"
                   title="{{ $color }}">
            </label>
        @endforeach

    </div>
@endif


   @if(!empty($product->size))
    <h4>Choose Size</h4>
    <div class="options">

        @php
            if (is_array($product->size)) {
                $sizes = $product->size;
            } elseif (is_string($product->size) && str_starts_with($product->size, '[')) {
                $sizes = json_decode($product->size, true);
            } else {
                $sizes = explode(',', $product->size);
            }
        @endphp

        @foreach($sizes as $i => $size)
            @php $size = trim($size); @endphp

            <input type="radio"
                   id="size{{ $i }}"
                   name="selected_size"
                   value="{{ $size }}"
                   hidden
                   required>

            <label for="size{{ $i }}"
                   class="size-option">
                {{ $size }}
            </label>
        @endforeach

    </div>
@endif


    {{-- ERRORS --}}
    @if(session('error'))
        <p style="color:#c0392b; margin-top:10px;">{{ session('error') }}</p>
    @endif
<button type="submit" class="btn primary" onclick="return checkAuthAndOptions()">
    Add to Cart
</button>

</form>

<button class="btn primary" onclick="buyNowCheck()">
    Buy Now
</button>



    </div>

    <!-- REVIEWS UNDER PRODUCT -->
  


    {{-- RIGHT SIDE : REVIEWS --}}
    <div class="product-reviews">

        <h3>Reviews</h3>

        <div class="reviews">
            @foreach($product->reviews as $index => $review)
                <div class="review-box {{ $index >= 3 ? 'hidden extra-review' : '' }}">
                    <strong>{{ $review->customer?->user?->name ?? 'Unknown' }}</strong>
                    ⭐ {{ $review->rating }}

                    <p>{{ $review->comment }}</p>

                    @if($review->image)
                        <img src="{{ asset('storage/' . $review->image) }}"
                             style="width:120px; border-radius:10px;">
                    @endif

                    {{-- REMOVE REVIEW --}}
                   @if(auth()->check() && auth()->id() === $review->customer?->user_id)

    <div style="margin-top:8px">
        <button class="btn-edit"
            onclick="toggleEdit({{ $review->review_id }})">
            Edit
        </button>

        <form action="{{ route('reviews.destroy', $review->review_id) }}"
              method="POST" style="display:inline">
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn-danger"
                    onclick="return confirm('Are you sure you want to delete this review?')">
                Remove
            </button>
        </form>
    </div>

    {{-- EDIT FORM --}}
    <form action="{{ route('reviews.update', $review->review_id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="edit-form"
          id="edit-form-{{ $review->review_id }}"
          style="display:none">
        @csrf
        @method('PUT')

        <label>Rating</label>
        <select name="rating">
            @for($i=1;$i<=5;$i++)
                <option value="{{ $i }}"
                    {{ $review->rating == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>

        <label>Comment (optional)</label>
        <textarea name="comment">{{ $review->comment }}</textarea>

        <label>Change Image (optional)</label>
        <input type="file" name="image">

        <button class="btn primary" style="margin-top:8px">
            Save Changes
        </button>
    </form>

@endif

                </div>
            @endforeach
        </div>

        @if($product->reviews->count() > 3)
            <button class="view-more" onclick="toggleReviews(this)">
                View more reviews
            </button>
        @endif

        <hr style="margin:25px 0">

        {{-- ADD REVIEW --}}
        <h3>Add a Review</h3>

        <form action="{{ route('reviews.store', $product->product_id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <label>Rating</label>
            <select name="rating">
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>

            <label>Comment</label>
            <textarea name="comment" required></textarea>

            <label>Upload Image</label>
            <input type="file" name="image">

            <button class="btn primary" style="margin-top:10px">
                Submit Review
            </button>
        </form>

    </div>

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
        confirmButtonColor: '#C08A56',
        background: '#fffaf3',
        color: '#333',
        customClass: {
            popup: 'luxury-alert'
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
        showAlert('Login Required', 'Please login to continue', 'info');
        setTimeout(() => {
            window.location.href = "{{ route('login') }}";
        }, 1500);
        return false;
    }

    return checkOptions();
}

function buyNowCheck() {
    if (!isLoggedIn()) {
        showAlert('Login Required', 'Please login to continue', 'info');
        setTimeout(() => {
            window.location.href = "{{ route('login') }}";
        }, 1500);
        return;
    }

    if (!checkOptions()) return;

    window.location.href = "{{ route('checkout.now', $product->product_id) }}";
}
    function toggleEdit(id) {
    const form = document.getElementById('edit-form-' + id);
    form.style.display = form.style.display === 'none'
        ? 'block'
        : 'none';
}
function toggleReviews(btn) {
    document.querySelectorAll('.extra-review')
        .forEach(r => r.classList.toggle('hidden'));

    btn.textContent =
        btn.textContent === 'View more reviews'
        ? 'Show less'
        : 'View more reviews';
}
</script>