@extends('layouts.customer')

@section('content')
<section id="reviews" class="content-section active">
  <h2>My Reviews</h2>

  @if($reviews->count() > 0)
  <div class="review-list">
    @foreach($reviews as $review)
    <div class="review-card">
      <h4>{{ $review->product->product_name }}</h4>
      <p class="rating">
        @for($i=1; $i<=5; $i++)
          <i class="fa {{ $i <= $review->rating ? 'fa-star' : 'fa-star-o' }}"></i>
        @endfor
      </p>
      <p>{{ $review->comment }}</p>

      {{-- Display Image if exists --}}
      @if($review->image)
      <img src="{{ asset('storage/' . $review->image) }}" 
           alt="Review Image" 
           style="width:150px; border-radius:10px; margin-top:10px;">
      @endif

      <small>Reviewed on {{ \Carbon\Carbon::parse($review->review_date)->format('Y-m-d') }}</small>
    </div>
    @endforeach
  </div>
  @else
  <p>You haven’t reviewed any products yet.</p>
  @endif

  <style>
    /* Container */
    .review-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }

    /* Review Card */
    .review-card {
        background: #fff;
        border-radius: 10px;
        padding: 12px 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .review-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    /* Product name */
    .review-card h4 {
        font-size: 16px;
        margin: 0 0 6px;
        color: #333;
    }

    /* Rating stars */
    .review-card .rating {
        color: #ff8c00;  /* orange stars */
        font-size: 14px;
        margin-bottom: 6px;
    }

    .review-card .rating i {
        margin-right: 2px;
    }

    /* Comment text */
    .review-card p {
        font-size: 13px;
        color: #555;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    /* Review date */
    .review-card small {
        display: block;
        font-size: 11px;
        color: #999;
    }

    /* Responsive for mobile */
    @media screen and (max-width: 480px) {
        .review-card {
            padding: 10px;
        }
        
        .review-card h4 {
            font-size: 15px;
        }
        
        .review-card p {
            font-size: 12px;
        }
        
        .review-card .rating {
            font-size: 13px;
        }
        
        .review-card small {
            font-size: 10px;
        }
    }
  </style>
</section>
@endsection
