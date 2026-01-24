@extends('admin.layout')
@section('title','Shop Details')
@section('content')
<div class="card p-3">
    <h5>{{ $shop->shop_name }}</h5>
    <p>{{ $shop->description }}</p>
    <p><strong>Owner:</strong> {{ $shop->owner->user->name }}</p>
    <h6>Products</h6>
    <ul>
        @foreach($shop->products as $p)
            <li>{{ $p->product_name }} — {{ $p->price }} — Stock: {{ $p->stock_quantity }}</li>
            <li><img src="{{ asset('storage/' . $p->image_url) }}" alt="{{ $p->product_name }}" width="100"></li>
         <li>{{ $p->description }}</li>
         <li>Category: {{ $p->category->category_name }}</li>
      <li>
    SubCategory:
    <span class="subcategory-badge">
        {{ optional($p->subcategory)->subcategory_name ?? 'No P' }}
    </span>
</li>
</br>



         
         <style>
            /* Card container */
.card {
    max-width: 900px;
    margin: 30px auto;
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
}

/* Shop title */
.card h5 {
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

/* Description */
.card p {
    font-size: 15px;
    color: #555;
    margin-bottom: 12px;
}

/* Owner text */
.card p strong {
    color: #000;
}

/* Products heading */
.card h6 {
    margin-top: 30px;
    margin-bottom: 15px;
    font-size: 18px;
    font-weight: 600;
    color: #34495e;
    border-bottom: 2px solid #f1f1f1;
    padding-bottom: 8px;
}

/* Products list */
.card ul {
    list-style: none;
    padding: 0;
}

/* Single product block */
.card ul li {
    margin-bottom: 8px;
    font-size: 14px;
    color: #444;
}

/* Product image */
.card ul img {
    margin: 10px 0 15px;
    border-radius: 10px;
    border: 1px solid #eee;
    max-width: 120px;
}

/* Product separator */
.card ul li:first-child {
    font-weight: 600;
    color: #2c3e50;
}

/* Category labels */
.card ul li:nth-child(4),
.card ul li:nth-child(5) {
    font-size: 13px;
    color: #666;
}

/* Badge style (subcategory) */
.subcategory-badge {
    display: inline-block;
    padding: 4px 10px;
    background: #ecf0f1;
    color: #555;
    border-radius: 20px;
    font-size: 12px;
    margin-left: 5px;
}

/* Responsive */
@media (max-width: 768px) {
    .card {
        padding: 20px;
    }

    .card h5 {
        font-size: 20px;
    }

    .card ul img {
        max-width: 100px;
    }
}
            </style>
           
        @endforeach
    </ul>
</div>
@endsection
