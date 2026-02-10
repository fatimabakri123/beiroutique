@extends('layouts.customer')

@section('content')
<div class="order-page">

    <h2>Order: {{ $product->product_name }}</h2>

    @php
    $productImage = null;

    if ($product->images && $product->images->count() > 0) {
        $productImage = $product->images->first()->image_path;
    } else {
        $productImage = $product->image_url;
    }
@endphp

<div class="product-image-wrapper">
    @if($productImage)
        <img
            src="{{ Str::startsWith($productImage, 'products/')
                ? asset('storage/'.$productImage)
                : asset($productImage) }}"
            alt="{{ $product->product_name }}"
        >
    @endif
</div>

<form action="{{ route('order.store', $product) }}" method="POST" id="orderForm">
    @csrf

    {{-- Customer Info --}}
    <div class="card">
        <h4>👤 Customer Info</h4>
        <div class="grid-2">
            <div>
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Enter your name" required>
            </div>
            <div>
                <label>Phone Number</label>
                <input type="text" name="phone" placeholder="Enter your phone" required>
            </div>
        </div>
    </div>

    {{-- Quantity & Price --}}
    <div class="card">
        <h4>📦 Quantity & Price</h4>
        <div class="grid-2">
            <div>
                <label>Quantity</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" required>
                <small>Available: {{ $product->stock_quantity }}</small>
                <span id="quantity-error" class="error-message"></span>
            </div>
            <div>
                <label>Total Price</label>
                <div id="loyalty-text" style="color:green; font-weight:400; font-size:0.9em;">
                    @if($loyaltyDiscount)
                        ({{ $loyaltyDiscount }}% loyalty discount will apply)
                    @endif
                </div>
                <div class="total-price-wrapper">
                    $<span id="total-price">0.00</span>
                    @if($product->is_on_sale)
                        <span style="color: #ef4444;">${{ number_format($product->discount_value, 2) }}</span>
                    @else
                        ${{ number_format($product->price, 2) }}
                    @endif
                </div>
                <small>Price per item: ${{ number_format($product->price,2) }}</small>
                <small id="deliveryFee"></small>
            </div>
        </div>
    </div>

    {{-- Options --}}
    {{-- Colors --}}
    @if(!empty($product->color))
    @php
        $colors = json_decode($product->color);
        if(json_last_error() !== JSON_ERROR_NONE) {
            $colors = explode(',', $product->color);
        }
    @endphp
    <div>
        <label>Color</label>
        <select name="color[]" id="colorSelect" multiple>
            @foreach($colors as $color)
                <option value="{{ trim($color) }}">{{ trim($color) }}</option>
            @endforeach
        </select>
        <small>Hold Ctrl/Cmd to select multiple</small>
    </div>
    @endif

    {{-- Sizes --}}
    @if(!empty($product->size))
    @php
        $sizes = json_decode($product->size);
        if(json_last_error() !== JSON_ERROR_NONE) {
            $sizes = explode(',', $product->size);
        }
    @endphp
    <div>
        <label>Size</label>
        <select name="size[]" id="sizeSelect" multiple>
            @foreach($sizes as $size)
                <option value="{{ trim($size) }}">{{ trim($size) }}</option>
            @endforeach
        </select>
    </div>
    @endif

    {{-- Payment & Delivery --}}
    <div class="card">
        <h4>💳 Payment & Delivery</h4>
        <div class="grid-2">
            <div>
                <label>Payment Method</label>
                <select name="payment_method_id" id="paymentSelect" required>
                    <option value="">-- Select Payment --</option>
                    @foreach($paymentMethods as $method)
                        @if($method->is_active)
                            <option value="{{ $method->payment_method_id }}">{{ ucfirst($method->method_name) }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label>Delivery Method</label>
                <select name="delivery_method_id" id="deliverySelect" required>
                    <option value="">-- Select Delivery --</option>
                    @foreach($deliveryMethods as $method)
                        @if($method->is_active)
                            <option 
                                value="{{ $method->delivery_method_id }}"
                                data-cost="{{ $method->cost }}"
                                data-name="{{ strtolower($method->method_name) }}"
                            >
                                {{ ucfirst($method->method_name) }} - ${{ number_format($method->cost,2) }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div id="stripeCardWrapper">
            <label>Credit Card Details</label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>
    </div>

    {{-- Address --}}
    <div class="card">
        <h4>🏠 Address</h4>
        <input type="text" name="shipping_address" placeholder="Street, Apartment, etc.">
        <input type="text" name="city" placeholder="City">
        <textarea name="additional_info" rows="2" placeholder="Additional details"></textarea>
    </div>

    {{-- Map --}}
    <div class="card">
        <h4>📍 Pick Your Location</h4>
        <button type="button" id="currentLocationBtn">Use My Current Location</button>
        <div id="map"></div>
    </div>

    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
    <input type="hidden" name="map_link" id="map_link">

    <button type="submit">Place Order</button>
</form>
</div>

<!-- Leaflet & Stripe -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://js.stripe.com/v3/"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const totalPriceSpan = document.getElementById('total-price');
    const pricePerItem = parseFloat(@json($product->price));
    const maxStock = parseInt(@json($product->stock_quantity));
    const paymentSelect = document.getElementById('paymentSelect');
    const deliverySelect = document.getElementById('deliverySelect');
    const deliveryFeeSpan = document.createElement('small');
    deliveryFeeSpan.classList.add('delivery-fee');
    totalPriceSpan.parentNode.appendChild(deliveryFeeSpan);
    const loyaltyText = document.getElementById('loyalty-text');
    const loyaltyDiscount = parseFloat(@json($loyaltyDiscount ?? 0));
    const form = document.getElementById('orderForm');
    const stripeWrapper = document.getElementById('stripeCardWrapper');

    quantityInput.setAttribute('max', maxStock);

    function sanitizeQuantity() {
        let qty = parseInt(quantityInput.value) || 1;
        if(qty < 1) qty = 1;
        if(qty > maxStock) qty = maxStock;
        quantityInput.value = qty;
        return qty;
    }

    function updateTotal() {
        const quantity = sanitizeQuantity();
        let basePrice = pricePerItem;
        @if($product->is_on_sale)
            basePrice = parseFloat(@json($product->discount_value));
        @endif

        let total = quantity * basePrice;

        // Loyalty discount
        if(loyaltyDiscount > 0) {
            const discountAmount = total * (loyaltyDiscount / 100);
            total -= discountAmount;
            loyaltyText.textContent = `-${loyaltyDiscount}% Loyalty Discount (-$${discountAmount.toFixed(2)})`;
        } else {
            loyaltyText.textContent = '';
        }

        // Delivery cost
        const selectedDelivery = deliverySelect.selectedOptions[0];
        if(selectedDelivery){
            const cost = parseFloat(selectedDelivery.dataset.cost || 0);
            total += cost;
            deliveryFeeSpan.textContent = `+ $${cost.toFixed(2)} delivery`;
        } else {
            deliveryFeeSpan.textContent = '';
        }

        // Disable Pickup if Cash on Delivery
        const selectedPayment = paymentSelect.selectedOptions[0]?.text.toLowerCase() || '';
        for(let i=0;i<deliverySelect.options.length;i++){
            const opt = deliverySelect.options[i];
            const name = opt.dataset.name || '';
            if(selectedPayment.includes('cash on delivery') && name.includes('pickup')){
                opt.disabled = true;
                if(deliverySelect.selectedIndex === i){
                    deliverySelect.selectedIndex = 0;
                }
            } else { opt.disabled = false; }
        }

        totalPriceSpan.textContent = total.toFixed(2);

        // Show Stripe if credit card
        stripeWrapper.style.display = selectedPayment.includes('credit card') ? 'block' : 'none';
    }

    quantityInput.addEventListener('input', updateTotal);
    paymentSelect.addEventListener('change', updateTotal);
    deliverySelect.addEventListener('change', updateTotal);
    updateTotal();

    // Stripe
    if(stripeWrapper){
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();
        const card = elements.create('card',{hidePostalCode:true});
        card.mount('#card-element');

        form.addEventListener('submit', async function(e){
            const selectedPayment = paymentSelect.selectedOptions[0]?.text.toLowerCase() || '';
            if(selectedPayment.includes('credit card')){
                e.preventDefault();
                const {error, paymentMethod} = await stripe.createPaymentMethod({type:'card',card:card});
                if(error){
                    document.getElementById('card-errors').textContent = error.message;
                } else {
                    const input = document.createElement('input');
                    input.type='hidden';
                    input.name='stripe_payment_method_id';
                    input.value=paymentMethod.id;
                    form.appendChild(input);
                    form.submit();
                }
            }
        });
    }

    // Map
    const map = L.map('map').setView([33.8938,35.5018],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
    const marker = L.marker([33.8938,35.5018],{draggable:true}).addTo(map);

    function updateLatLng(lat,lng){
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('map_link').value = `https://www.google.com/maps?q=${lat},${lng}`;
    }

    marker.on('dragend', e => updateLatLng(e.target.getLatLng().lat, e.target.getLatLng().lng));
    map.on('click', e => { marker.setLatLng(e.latlng); updateLatLng(e.latlng.lat,e.latlng.lng); });
    updateLatLng(33.8938,35.5018);

    document.getElementById('currentLocationBtn').addEventListener('click', function(){
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(pos=>{
                const lat=pos.coords.latitude;
                const lng=pos.coords.longitude;
                marker.setLatLng([lat,lng]);
                map.setView([lat,lng],16);
                updateLatLng(lat,lng);
            },()=>{ alert('Cannot get your location'); });
        } else { alert('Geolocation not supported'); }
    });

    L.Control.geocoder({defaultMarkGeocode:true,placeholder:'Search address...'})
        .on('markgeocode', function(e){
            const latlng = e.geocode.center;
            marker.setLatLng(latlng);
            map.setView(latlng,16);
            updateLatLng(latlng.lat,latlng.lng);
        }).addTo(map);
});
</script>
<style>


.order-page {
  max-width: 750px;
  margin: 30px auto;
  font-family: Arial, sans-serif;
  background: var(--bg-light);
  color: var(--text-dark);
}

.order-page h2 {
  text-align: center;
  margin-bottom: 25px;
  color: var(--order-heading);
  font-weight: 700;
}

.product-image-wrapper {
  display: flex;
  justify-content: center;
  margin-bottom: 25px;
}

.product-image-wrapper img {
  width: 180px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.card {
  background: var(--order-bg-card);
  padding: 15px 20px;
  border-radius: 12px;
  margin-bottom: 15px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.card h4 {
  margin-bottom: 15px;
  color: var(--order-heading);
}

.grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
}

input, select, textarea {
  width: 100%;
  padding: 8px;
  border-radius: 8px;
  border: 1px solid var(--order-input-border);
  transition: 0.2s;
}

input:focus, select:focus, textarea:focus {
  border-color: var(--order-border-focus);
  outline: none;
}

.total-price-wrapper {
  padding: 8px;
  border-radius: 8px;
  background: var(--order-price-bg);
  font-weight: 600;
}

#deliveryFee {
  color: var(--order-heading);
  display: block;
  margin-top: 5px;
}

#currentLocationBtn,
button[type="submit"] {
  width: 100%;
  padding: 12px;
  background:  linear-gradient(135deg,#8f3f9beb,#1f7bb8eb,#5b2a86);
  color: var(--white);
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
}

#currentLocationBtn:hover,
button[type="submit"]:hover {
  background:  linear-gradient(135deg,#8f3f9beb,#1f7bb8eb,#5b2a86);
}

#stripeCardWrapper {
  display: none;
  margin-top: 15px;
}

#card-element {
  padding: 10px;
  border: 1px solid var(--order-input-border);
  border-radius: 8px;
}

#card-errors {
  color: red;
  margin-top: 5px;
}

#map {
  width: 100%;
  height: 250px;
  border-radius: 8px;
}
.error-message {
    color: #ff4d4f;
    font-size: 0.875rem;
    margin-top: 5px;
    display: block;
    transition: opacity 0.3s ease;
}


</style>

@endsection
