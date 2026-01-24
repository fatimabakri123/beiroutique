<div id="search-results">
    <div class="product-grid">
        @foreach($products ?? [] as $product)
            <div class="product-card">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                <p class="title">{{ $product->name }}</p>
                <p class="price">${{ $product->price }}</p>
            </div>
        @endforeach
    </div>
</div>
