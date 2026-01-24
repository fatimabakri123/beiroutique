<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; background:#f9f7f4; padding:20px;">

    <h2 style="color:#8B5E3C;">
    🔥 {{ $shopName }} Shop has a SALE!
</h2>

@if(isset($product))
    <p>
        <strong>{{ $product->product_name }}</strong> is now on sale!
    </p>
    <p>New Price: <strong>${{ $product->discount_value }}</strong></p>
@else
    <p>
        The shop has applied a
        <strong>{{ $percentage }}% discount</strong>
        on selected products!
    </p>
    <a href="{{ url('/') }}" style="display:inline-block; padding:10px 20px; background:#8B5E3C; color:#fff; text-decoration:none; border-radius:5px;">
    Shop Now
</a>

@endif

    <p style="margin-top:20px;">
        🛍️ Visit the shop now before the sale ends!
    </p>

    <hr>
    <small>This email was sent automatically.</small>

</body>
</html>
