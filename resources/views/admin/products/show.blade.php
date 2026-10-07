@extends('admin.layout')

@section('title', 'Product Details')

@section('content')
<div class="card p-4">
     <div style="margin-bottom: 20px;">
        <a href="{{ url()->previous() }}" class="btn-back">← Back</a>
        <style>
            .btn-back { 
    display: inline-block; 
    padding: 8px 16px; 
    border-radius: 10px; 
    background: #fff; 
    border: 2px solid #7b2fae; 
    color: #7b2fae; 
    font-weight: 600; 
    text-decoration: none; 
    transition: all 0.3s ease; 
}
.btn-back:hover { 
    background: linear-gradient(135deg, #7b2fae, #a64dd1); 
    color: #fff; 
    transform: translateY(-2px) scale(1.05); 
    box-shadow: 0 6px 18px rgba(124,77,255,0.4); 
}
        </style>
    </div>
    <h3>{{ $product->product_name }}</h3>

    @php
     
        $images = collect();
        if ($product->images && $product->images->count()) {
            $images = $product->images;
        } elseif (!empty($product->image_url)) {
            $images = collect([(object)['image_path' => $product->image_url]]);
        }
    @endphp

    {{-- Product Slider --}}
    <div class="product-slider">
        @foreach($images as $img)
            <img 
                src="{{ Str::startsWith($img->image_path, 'products/') ? asset('storage/'.$img->image_path) : asset($img->image_path) }}" 
                class="slider-img {{ $loop->first ? 'active' : '' }}" 
                alt="{{ $product->product_name }}">
        @endforeach

        @if($images->count() > 1)
            <button class="slider-btn prev">‹</button>
            <button class="slider-btn next">›</button>
        @endif
    </div>

    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
    <p><strong>SKU:</strong> {{ $product->sku }}</p>
</div>

<style>
.card {
    max-width: 650px;
    margin: 30px auto;
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 12px 30px rgba(124, 77, 255, 0.08);
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(124, 77, 255, 0.15);
}
.card h3 {
    font-size: 26px;
    font-weight: 700;
    color: #6311ac;
    margin-bottom: 20px;
    text-align: center;
}

.product-slider {
    position: relative;
    width: 100%;
    max-width: 500px;
    margin: 0 auto 20px;
    overflow: hidden;
    border-radius: 14px;
}

.product-slider img {
    width: 100%;
    height: 360px;         
    object-fit: contain;   
    background: #f6f6f6;  
    display: none;
    border-radius: 14px;
}


.product-slider img.active {
    display: block;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.8);
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    z-index: 5;
}
.slider-btn.prev { left: 8px; }
.slider-btn.next { right: 8px; }
.slider-btn:hover { background: white; }

.card p {
    font-size: 15px;
    color: #555;
    margin: 6px 0;
}
.card p strong { color: #2c3e50; }

@media (max-width: 768px) {
    .product-slider img { height: 200px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.product-slider');
    if(!slider) return;

    const images = slider.querySelectorAll('.slider-img');
    let index = 0;

    const prevBtn = slider.querySelector('.prev');
    const nextBtn = slider.querySelector('.next');

    function showImage(i) {
        images.forEach(img => img.classList.remove('active'));
        images[i].classList.add('active');
    }

    if(prevBtn){
        prevBtn.addEventListener('click', () => {
            index = (index - 1 + images.length) % images.length;
            showImage(index);
        });
    }

    if(nextBtn){
        nextBtn.addEventListener('click', () => {
            index = (index + 1) % images.length;
            showImage(index);
        });
    }
});
</script>
@endsection
