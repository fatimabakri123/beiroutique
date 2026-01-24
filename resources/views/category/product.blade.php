<h3>Products in "{{ $subcategory->subcategory_name }}"</h3>

@if($products->count())
<div class="products-grid">
    @foreach($products as $product)
    <div class="product-card">
        <a href="{{ route('product.show', $product->product_id) }}">
           <img src="{{ Str::startsWith($product->image_url, 'products/') ? asset('storage/' . $product->image_url) : asset($product->image_url) }}" alt="{{ $product->product_name }}">

        </a>
        
        <div class="product-info">
            <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
    
            <p><h4>{{ $product->product_name }}</h4></p>
            <p class="price">${{ number_format($product->price, 2) }}</p>
           <p>{{ $product->shop?->shop_name ?? 'No Shop' }}</p>

        </div>
    </div>
    @endforeach
</div>
<style>
    /* ===== General ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  background: #fff;
  color: #3e2a1f;
  padding: 20px 40px;
}

/* ===== Heading ===== */
h3 {
  font-size: 22px;
  color: #C08A56;
  margin-bottom: 20px;
}

/* ===== Products Grid ===== */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
  gap: 25px;
}

/* ===== Product Card ===== */
.product-card {
  background: #fff;
  border-radius: 15px;
  overflow: hidden;
  border: 1px solid #eee;
  text-align: center;
  transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* Product Image */
.product-card img {
  width: 100%;
  height: 260px;
  object-fit: cover;
  border-bottom: 1px solid #eee;
}

/* Product Info */
.product-info {
  padding: 12px;
}

.product-info h4 {
  font-size: 15px;
  margin-bottom: 8px;
  color: #3e2a1f;
}

.product-info .price {
  font-weight: bold;
  color: #C08A56;
}

/* ===== Responsive ===== */
@media(max-width:900px) {
  body {
    padding: 15px 20px;
  }
  .products-grid {
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
  }
  .product-card img {
    height: 200px;
  }
}
</style>
@else
<p>No products in this subcategory.</p>
@endif
