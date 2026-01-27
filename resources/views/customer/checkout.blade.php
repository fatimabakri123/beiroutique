<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <section class="content-section">
    <h2>Checkout</h2>

    <h4>Order Summary</h4>
    <ul>
  @foreach($cartItems as $index => $item)
    <li>
        <strong>{{ $item->product->product_name }}</strong><br>
        Quantity: {{ $item->quantity }} <br>

        @if($item->color)
            Color: <span>{{ $item->color }}</span><br>
        @endif

        @if($item->size)
            Size: <span>{{ $item->size }}</span><br>
        @endif
    </li>

    <!-- Hidden inputs to send with the form -->
    <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
    <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
    <input type="hidden" name="items[{{ $index }}][color]" value="{{ $item->color }}">
    <input type="hidden" name="items[{{ $index }}][size]" value="{{ $item->size }}">
@endforeach

    </ul>

    <p><strong>Total: ${{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity), 2) }}</strong></p>

    <h4>Shipping Information</h4>

    <form action="{{ route('checkout.submit') }}" method="POST">
        @csrf

        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>Phone:</label>
        <input type="text" name="phone" required>

        <label>Address:</label>
        <textarea name="address" required></textarea>
        <lable>Payment Method:</lable>
        <select name="payment_method_id" required>
            @foreach($paymentMethods as $method)
                <option value="{{ $method->payment_method_id }}">
                    {{ ucfirst($method->method_name) }}
                </option>
            @endforeach
        </select>
        <label>Delivery Method:</label>
        <select name="delivery_method_id" required>
            @foreach($deliveryMethods as $method)
                <option value="{{ $method->delivery_method_id }}">
                    {{ ucfirst($method->method_name) }} - ${{ number_format($method->cost, 2) }} (Est: {{ $method->estimated_time }})
                </option>
            @endforeach
        </select>

       <button type="button" class="btn" onclick="openConfirm()">Place Order</button>

    </form>
</section>

<style>
   body {
    font-family: Arial, sans-serif;
    background: #f3e9dd;
    margin: 0;
    padding: 0;
}

.content-section {
    width: 40%;
    margin: 40px auto;
    background: #fffaf3;
    padding: 20px 25px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(140, 98, 57, 0.18);
    border: 1px solid #e7d8c5;
}

h2 {
    text-align: center;
    margin-bottom: 15px;
    color: #6b4f33;
}

h4 {
    margin-top: 20px;
    color: #8a6a48;
    font-size: 16px;
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

ul li {
    background: #f9f1e5;
    margin-bottom: 8px;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #e4d5c3;
    font-size: 14px;
    color: #5c4731;
}

form {
    margin-top: 15px;
    display: flex;
    flex-direction: column;
}

label {
    margin-top: 12px;
    font-weight: bold;
    color: #6b4f33;
    font-size: 14px;
}

input[type="text"],
textarea {
    margin-top: 5px;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #c8b39a;
    font-size: 13px;
    width: 100%;
    background: #fffaf3;
    color: #4e3b28;
}

textarea {
    height: 80px;
    resize: none;
}

.btn {
    margin-top: 20px;
    padding: 12px;
    background: #8b5e3c;
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
    transition: .3s;
}

.btn:hover {
    background: #6b4f33;
}

/* Mobile */
@media(max-width: 768px) {
    .content-section {
        width: 90%;
        padding: 18px;
    }
}
.confirm-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.45);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.confirm-box {
  background: #fffaf3;
  padding: 25px 30px;
  border-radius: 14px;
  width: 90%;
  max-width: 360px;
  text-align: center;
  box-shadow: 0 6px 18px rgba(0,0,0,0.25);
}

.confirm-box h3 {
  margin-bottom: 10px;
  color: #6b4f33;
}

.confirm-box p {
  font-size: 14px;
  color: #5c4731;
  margin-bottom: 20px;
}

.confirm-actions {
  display: flex;
  gap: 15px;
  justify-content: center;
}

.confirm-btn {
  background: #8b5e3c;
  color: white;
  padding: 10px 16px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
}

.cancel-btn {
  background: #e0d0bb;
  color: #6b4f33;
  padding: 10px 16px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
}

.cancel-btn:hover {
  background: #cbb49a;
}


</style>
<div class="confirm-overlay" id="confirmOverlay">
  <div class="confirm-box">
    <h3>Confirm Your Order</h3>
    <p>Are you sure you want to place this order?</p>

    <div class="confirm-actions">
      <button class="confirm-btn" onclick="submitCheckout()">Yes, Place Order</button>
      <button class="cancel-btn" onclick="closeConfirm()">Cancel</button>
    </div>
  </div>
</div>
<script>
function openConfirm() {
  document.getElementById('confirmOverlay').style.display = 'flex';
}

function closeConfirm() {
  document.getElementById('confirmOverlay').style.display = 'none';
}

function submitCheckout() {
  document.querySelector('form').submit();
}
</script>

</body>
</html>


