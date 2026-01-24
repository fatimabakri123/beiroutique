<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    foreach($products as $p)
    <div>
        <h3>{{ $p->product_name }}</h3>
        <p>Shop: {{ $p->shop->shop_name ?? '-' }}</p>
        <p>Category: {{ $p->category->category_name ?? '-' }}</p>
        <p>Price: {{ $p->price }}</p>
        <p>Stock: {{ $p->stock_quantity }}</p>
        <p>Status: {{ $p->is_on_sale ? 'On Sale':'Active' }}</p>
    </div>
    @endforeach
</body>
</html>