@extends('layouts.customer')

@section('content')
<section id="reviews" class="content-section active review-page">

  <!-- Back Button -->
  <div class="back-btn-wrapper">
    
  </div>

  <h2 class="review-title">⭐ My Reviews</h2>

  @if($reviews->count() > 0)

  <!-- HEADER ROW (like table) -->
  <div class="review-table-header">
    <div>Product</div>
    <div>Comment</div>
    <div>Rating</div>
    <div>Image</div>
    <div>Actions</div>
  </div>

  <div class="review-list">
    @foreach($reviews as $review)
      <div class="review-card" data-id="{{ $review->review_id }}">

        <!-- Product -->
      <div class="review-header">
  @php
      $productImage = null;
      if ($review->product) {
          if ($review->product->images()->exists()) {
              $productImage = $review->product->images()->first()->image_path;
          } else {
              $productImage = $review->product->image_url;
          }
      }
  @endphp

  @if($productImage)
      <img src="{{ Str::startsWith($productImage, 'products/') 
                    ? asset('storage/' . $productImage) 
                    : asset($productImage) }}" 
           alt="{{ $review->product->product_name }}">
  @endif
  <h4>{{ $review->product->product_name }}</h4>
</div>


        <!-- Content as grid cells -->
        <div class="review-content">

          <p class="review-text display-comment">{{ $review->comment }}</p>

          <p class="rating display-rating">
            @for($i=1; $i<=5; $i++)
              <i class="fa {{ $i <= $review->rating ? 'fa-star' : 'fa-star-o' }}"></i>
            @endfor
          </p>

          @if($review->image)
            <img class="review-image display-image" src="{{ asset('storage/' . $review->image) }}" alt="Review Image">
          @else
            <span class="no-img">—</span>
          @endif

          <div class="review-actions">
            <button type="button" class="edit-btn">Edit</button>
            <form action="{{ route('reviews.destroy', $review->review_id) }}" method="POST" onsubmit="return confirm('Delete this review?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete-btn">Delete</button>
            </form>
          </div>

          <!-- Edit Form -->
          <form class="edit-form" action="{{ route('reviews.update', $review->review_id) }}" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            @method('PUT')
            <textarea name="comment" rows="3">{{ $review->comment }}</textarea>
            <select name="rating">
              @for($i=1; $i<=5; $i++)
                <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
              @endfor
            </select>
            <input type="file" name="image" accept="image/*">
            <div class="edit-actions">
              <button type="submit" class="submit-btn">Update</button>
              <button type="button" class="cancel-btn">Cancel</button>
            </div>
          </form>

        </div>
      </div>
    @endforeach
  </div>

  @else
    <p class="no-reviews">You haven’t reviewed any products yet.</p>
  @endif

</section>

<style>
/* ===== PAGE ===== */
.review-page { 
  padding: 20px 40px; 
  min-height: 100vh; 
  background: linear-gradient(135deg, #fdfcff, #f6f0ff);
}
.back-btn-wrapper { margin-bottom: 20px; }
.back-btn {
  display: inline-flex; align-items: center;
  padding: 10px 18px; background: #5b93c7; color: #fff;
  font-weight: 600; border-radius: 12px; text-decoration: none;
}
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
.rating{ grid-column:3; text-align:center; color:#facc15; }
.review-image{ grid-column:4; width:90px; height:90px; object-fit:cover; border-radius:10px; border:2px solid #ccc; margin:auto; }
.no-img{ grid-column:4; text-align:center; color:#999; }
.review-actions{ grid-column:5; display:flex; gap:8px; justify-content:center; }

/* ===== EDIT ===== */
.edit-form{ grid-column:2 / span 4; margin-top:10px; }
.edit-form textarea,.edit-form select,.edit-form input{
  width:100%; margin-bottom:8px; padding:6px 10px; border-radius:8px; border:1px solid #ccc;
}
.edit-actions{ display:flex; gap:8px; }

/* ===== BUTTONS ===== */
.submit-btn{background:#4caf50;color:#fff;}
.cancel-btn,.delete-btn{background:#f44336;color:#fff;}
.edit-btn{ background: linear-gradient(135deg, #a080bc, #5b93c7);color:#fff;}
.submit-btn,.cancel-btn,.edit-btn,.delete-btn{
  border:none; padding:6px 12px; border-radius:8px; cursor:pointer;font-size:18px;
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

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const card = btn.closest('.review-card');
      card.querySelector('.edit-form').style.display='block';
      card.querySelector('.display-comment').style.display='none';
      card.querySelector('.display-rating').style.display='none';
      const img = card.querySelector('.display-image');
      if(img) img.style.display='none';
    });
  });

  document.querySelectorAll('.cancel-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const card = btn.closest('.review-card');
      card.querySelector('.edit-form').style.display='none';
      card.querySelector('.display-comment').style.display='block';
      card.querySelector('.display-rating').style.display='block';
      const img = card.querySelector('.display-image');
      if(img) img.style.display='block';
    });
  });
});
</script>

@endsection