@if($products->isEmpty())
    <p>No products found.</p>
@else
    <div class="search-results-grid" style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach($products as $product)
            @php
                // Full path to the image in storage
                $imagePath = storage_path('app/public/products/' . $product->image);
            @endphp

            <div class="product-card" style="width: 200px; border: 1px solid #ddd; padding: 10px; border-radius: 8px; text-align: center;">
                <img 
                    src="{{ file_exists($imagePath) && $product->image ? asset('storage/products/' . $product->image) : asset('images/default.jpg') }}" 
                    alt="{{ $product->name }}" 
                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;"
                >
                <h3 style="margin: 10px 0 5px 0; font-size: 16px;">{{ $product->name }}</h3>
                <p style="color: #555; font-size: 14px;">${{ $product->price }}</p>
            </div>
        @endforeach
    </div>
@endif
