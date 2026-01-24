<div class="product-grid">
    @forelse($products as $product)
        <div class="product-card">
            <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}" />
            <p class="title">{{ $product->product_name }}</p>
            <p class="price">${{ $product->price }}</p>
        </div>
    @empty
        <p>No products found.</p>
    @endforelse
</div>
