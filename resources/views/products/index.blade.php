<style>
    .products-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 10px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .product-card {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: 0.2s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .product-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }

    .product-card h4 {
        font-size: 17px;
        margin: 10px 0 5px;
        color: #333;
    }

    .product-card span {
        font-size: 15px;
        color: #777;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 25px;
        list-style: none;
        padding: 0;
        gap: 8px;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination a, .pagination span {
        padding: 8px 14px;
        background: #eee;
        border-radius: 6px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        transition: 0.2s;
    }

    .pagination a:hover {
        background: #C08A56;
        color: #fff;
    }

    .pagination .active span {
        background: #C08A56;
        color: #fff;
    }
</style>


<div class="products-container">

    <h2 style="text-align:center; margin-bottom:20px;">All Products</h2>

    <div class="products-grid">
        @foreach($products as $product)
        <div class="product-card">
            <img src="{{ asset($product->image_url) }}" alt="">
            <h4>{{ $product->product_name }}</h4>
            <span>${{ number_format($product->price, 2) }}</span>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div>
        {{ $products->links() }}
    </div>
</div>
