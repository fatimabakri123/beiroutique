@extends('layouts.customer')

@section('content')
<div class="order-page" style="max-width:750px; margin:30px auto; font-family:Arial, sans-serif;">

    <h2 style="text-align:center; margin-bottom:25px; color:#C08A56; font-weight:700;">
        Order: {{ $product->product_name }}
    </h2>

    <div style="display:flex; justify-content:center; margin-bottom:25px;">
        <img src="{{ Str::startsWith($product->image_url, 'storage/') ? asset($product->image_url) : asset('storage/' . $product->image_url) }}"
             alt="{{ $product->product_name }}"
             style="width:180px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
    </div>

    <form action="{{ route('order.store', $product) }}" method="POST">
        @csrf

        {{-- Customer Info Card --}}
        <div style="background:#fff6f0; padding:15px 20px; border-radius:12px; margin-bottom:15px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom:15px; color:#C08A56;">👤 Customer Info</h4>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div>
                    <label style="font-weight:600;">Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter your name" required
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px; transition:0.2s;"
                           onfocus="this.style.borderColor='#C08A56'" onblur="this.style.borderColor='#ccc'">
                </div>
                <div>
                    <label style="font-weight:600;">Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter your phone" required
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px; transition:0.2s;"
                           onfocus="this.style.borderColor='#C08A56'" onblur="this.style.borderColor='#ccc'">
                </div>
            </div>
        </div>

        {{-- Quantity Card --}}
        <div style="background:#fff6f0; padding:15px 20px; border-radius:12px; margin-bottom:15px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom:15px; color:#C08A56;">📦 Quantity & Price</h4>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div>
                    <label style="font-weight:600;">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" required
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px; transition:0.2s;"
                           onfocus="this.style.borderColor='#C08A56'" onblur="this.style.borderColor='#ccc'">
                    <small style="color:#555;">Available: {{ $product->stock_quantity }}</small>
                </div>
                <div>
                    <label style="font-weight:600;">Total Price</label>
                    <div style="padding:8px; border-radius:8px; background:#fff3e6; font-weight:600;">
                        $<span id="total-price">{{ number_format($product->price, 2) }}</span>
                    </div>
                    <small style="color:#555;">Price per item: ${{ number_format($product->price,2) }}</small>
                </div>
            </div>
        </div>

        {{-- Options Card --}}
        @if(!empty($product->color) || !empty($product->size))
        <div style="background:#fff6f0; padding:15px 20px; border-radius:12px; margin-bottom:15px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom:15px; color:#C08A56;">🎨 Options</h4>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                @if(!empty($product->color))
                <div>
                    <label style="font-weight:600;">Color</label>
                    <select name="color[]" multiple style="width:100%; padding:8px; border-radius:8px; transition:0.2s;">
                        @foreach(explode(',', $product->color) as $color)
                            <option value="{{ trim($color) }}">{{ trim($color) }}</option>
                        @endforeach
                    </select>
                    <small style="color:#555;">Hold Ctrl/Cmd to select multiple</small>
                </div>
                @endif

                @if(!empty($product->size))
                <div>
                    <label style="font-weight:600;">Size</label>
                    <select name="size[]" multiple style="width:100%; padding:8px; border-radius:8px; transition:0.2s;">
                        @foreach(explode(',', $product->size) as $size)
                            <option value="{{ trim($size) }}">{{ trim($size) }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Payment & Delivery Card --}}
        <div style="background:#fff6f0; padding:15px 20px; border-radius:12px; margin-bottom:15px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom:15px; color:#C08A56;">💳 Payment & Delivery</h4>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div>
                    <label style="font-weight:600;">Payment Method</label>
                    <select name="payment_method_id" required style="width:100%; padding:8px; border-radius:8px;">
                        <option value="">-- Select Payment --</option>
                        @foreach($paymentMethods as $method)
                            @if($method->is_active)
                                <option value="{{ $method->payment_method_id }}">{{ ucfirst($method->method_name) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-weight:600;">Delivery Method</label>
                    <select name="delivery_method_id" required style="width:100%; padding:8px; border-radius:8px;">
                        <option value="">-- Select Delivery --</option>
                        @foreach($deliveryMethods as $method)
                            @if($method->is_active)
                                <option value="{{ $method->delivery_method_id }}">
                                    {{ ucfirst($method->method_name) }} - ${{ number_format($method->cost,2) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Address Card --}}
        <div style="background:#fff6f0; padding:15px 20px; border-radius:12px; margin-bottom:15px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom:15px; color:#C08A56;">🏠 Address</h4>
            <input type="text" name="shipping_address" placeholder="Street, Apartment, etc."
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; margin-bottom:10px;">
            <input type="text" name="city" placeholder="City"
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; margin-bottom:10px;">
            <textarea name="additional_info" rows="2" placeholder="Additional details"
                      style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc;"></textarea>
        </div>

        {{-- Map Card --}}
        <div style="background:#fff6f0; padding:15px 20px; border-radius:12px; margin-bottom:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom:10px; color:#C08A56;">📍 Pick Your Location</h4>
            <button type="button" id="currentLocationBtn" style="margin-bottom:10px; padding:8px 12px; border:none; border-radius:6px; background:#C08A56; color:#fff; cursor:pointer;">
                Use My Current Location
            </button>
            <div id="map" style="width:100%; height:250px; border-radius:8px;"></div>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="map_link" id="map_link">

        <button type="submit" style="width:100%; padding:12px; background:#C08A56; color:#fff; border:none; border-radius:8px; font-size:16px; cursor:pointer; transition:0.3s;">
            Place Order
        </button>
    </form>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<script>
    // Total price & quantity validation
    const quantityInput = document.getElementById('quantity');
    const totalPriceSpan = document.getElementById('total-price');
    const pricePerItem = {{ $product->price }};
    const maxStock = {{ $product->stock_quantity }};
    quantityInput.setAttribute('max', maxStock);

    quantityInput.addEventListener('input', function() {
        let quantity = parseInt(this.value) || 1;
        if(quantity > maxStock){ alert(`Only ${maxStock} available.`); this.value = maxStock; quantity = maxStock; }
        else if(quantity < 1){ this.value = 1; quantity = 1; }
        totalPriceSpan.textContent = (quantity * pricePerItem).toFixed(2);
    });

    // Map init
    const map = L.map('map').setView([33.8938, 35.5018], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
    let marker = L.marker([33.8938, 35.5018], { draggable:true }).addTo(map);

    function updateLatLng(lat,lng){
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('map_link').value = `https://www.google.com/maps?q=${lat},${lng}`;
    }

    marker.on('dragend', e => updateLatLng(e.target.getLatLng().lat, e.target.getLatLng().lng));
    map.on('click', e => { marker.setLatLng(e.latlng); updateLatLng(e.latlng.lat, e.latlng.lng); });
    updateLatLng(33.8938, 35.5018);

    document.getElementById('currentLocationBtn').addEventListener('click', function(){
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(pos=>{
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                marker.setLatLng([lat,lng]);
                map.setView([lat,lng],16);
                updateLatLng(lat,lng);
            }, err=>{ alert('Cannot get your location'); });
        } else { alert('Geolocation not supported'); }
    });

    L.Control.geocoder({ defaultMarkGeocode:true, placeholder:'Search address...'})
        .on('markgeocode', function(e){ const latlng=e.geocode.center; marker.setLatLng(latlng); map.setView(latlng,16); updateLatLng(latlng.lat,latlng.lng); })
        .addTo(map);
        // Payment & Delivery logic
const paymentSelect = document.querySelector('select[name="payment_method_id"]');
const deliverySelect = document.querySelector('select[name="delivery_method_id"]');

// إضافة عنصر لعرض رسوم التوصيل
let deliveryFeeSpan = document.createElement('small');
deliveryFeeSpan.style.color = '#C08A56';
deliveryFeeSpan.style.display = 'block';
deliveryFeeSpan.style.marginTop = '5px';
totalPriceSpan.parentNode.appendChild(deliveryFeeSpan);

paymentSelect.addEventListener('change', function() {
    const selectedPayment = paymentSelect.options[paymentSelect.selectedIndex].text.toLowerCase();
    let originalQuantity = parseInt(quantityInput.value) || 1;
    let total = originalQuantity * pricePerItem;

    if(selectedPayment.includes('cash on delivery')) {
        // Increase $5 on total
        total += 5;
        totalPriceSpan.textContent = total.toFixed(2);
        deliveryFeeSpan.textContent = '+ $5 Delivery Fee';

        // Disable other delivery options except Free Pickup
        for(let i=0; i<deliverySelect.options.length; i++){
            const optionText = deliverySelect.options[i].text.toLowerCase();
            if(!optionText.includes('free pickup')) {
                deliverySelect.options[i].disabled = true;
            } else {
                deliverySelect.selectedIndex = i; // auto-select Free Pickup
            }
        }
    } else {
        // Re-enable all delivery options
        for(let i=0; i<deliverySelect.options.length; i++){
            deliverySelect.options[i].disabled = false;
        }
        // Reset total price
        totalPriceSpan.textContent = (originalQuantity * pricePerItem).toFixed(2);
        deliveryFeeSpan.textContent = '';
    }
});

// Update total price if quantity changes and Cash on Delivery is selected
quantityInput.addEventListener('input', function() {
    let quantity = parseInt(this.value) || 1;
    if(quantity > maxStock){ alert(`Only ${maxStock} available.`); this.value = maxStock; quantity = maxStock; }
    else if(quantity < 1){ this.value = 1; quantity = 1; }

    let selectedPayment = paymentSelect.options[paymentSelect.selectedIndex].text.toLowerCase();
    let total = quantity * pricePerItem;
    if(selectedPayment.includes('cash on delivery')) {
        total += 5;
        deliveryFeeSpan.textContent = '+ $5 Delivery Fee';
    } else {
        deliveryFeeSpan.textContent = '';
    }
    totalPriceSpan.textContent = total.toFixed(2);
});

</script>
@endsection
