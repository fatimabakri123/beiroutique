<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Beiroutique</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* ===== COLOR SYSTEM ===== */
        :root {
            --purple-dark: #5b2a86;
            --purple-soft: #1f7bb8eb;
            --blue-soft: #8f3f9beb;
            --gold: #d4af37;
            --pink: #ff4d94;
            --success: #10b981;
            --error: #ef4444;
            
            --bg-light: #fdfcff;
            --white: #ffffff;
            --text-dark: #1e1b4b;
            --text-muted: #6b7280;
            --border-soft: rgba(226,232,240,0.8);
            --shadow-soft: 0 18px 40px rgba(91, 42, 134, 0.18);
            --shadow-hard: 0 20px 60px rgba(91, 42, 134, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #f0f4f8 100%);
            color: var(--text-dark);
            min-height: 100vh;
            padding: 20px;
        }

        /* ===== CONTAINER ===== */
        .content-section {
            width: 900px;
            max-width: 95%;
            margin: 50px auto;
            background: var(--white);
            padding: 40px;
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
            position: relative;
            overflow: hidden;
        }

        .content-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--purple-dark), var(--purple-soft), var(--blue-soft));
        }

        /* ===== BACK BUTTON ===== */
        .back-btn-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(124, 77, 255, 0.25);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(96, 165, 250, 0.35);
            color: #fff;
        }

        .back-btn i {
            font-size: 14px;
        }

        /* ===== HEADINGS ===== */
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--purple-dark);
            font-size: 2.2rem;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--purple-dark), var(--purple-soft));
            border-radius: 2px;
        }

        h4 {
            margin-top: 35px;
            margin-bottom: 20px;
            color: var(--purple-dark);
            font-size: 1.4rem;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-soft);
        }

        /* ===== LOYALTY BADGE ===== */
        .loyalty-badge {
            background: linear-gradient(135deg, var(--gold), #fbbf24);
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-left: 10px;
        }

        /* ===== ORDER SUMMARY ===== */
        .order-summary {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .order-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .order-item {
            background: var(--white);
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .order-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-color: var(--purple-soft);
        }

        .item-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid transparent;
            background: linear-gradient(45deg, var(--purple-dark), var(--purple-soft)) border-box;
            padding: 2px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: var(--purple-dark);
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .item-meta {
            display: flex;
            gap: 15px;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .item-price {
            color: var(--purple-dark);
            font-weight: 600;
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
            margin-right: 5px;
        }

        .sale-price {
            color: var(--error);
            font-weight: 600;
        }

        /* ===== PRICE BREAKDOWN ===== */
        .price-breakdown {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid var(--border-soft);
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed var(--border-soft);
        }

        .price-row:last-child {
            border-bottom: none;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--purple-dark);
            padding-top: 15px;
            margin-top: 10px;
        }

        .loyalty-discount {
            color: var(--success);
            font-weight: 600;
        }

        .delivery-cost {
            color: var(--purple-soft);
        }

        .orders-count {
            color: var(--gold);
            font-weight: 600;
        }

        /* ===== FORM GRID ===== */
        form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        label {
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--purple-dark);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        label i {
            color: var(--purple-soft);
            font-size: 0.9rem;
        }

        input[type="text"],
        select,
        textarea {
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid var(--border-soft);
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--purple-soft);
            box-shadow: 0 0 0 3px rgba(91, 42, 134, 0.1);
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* ===== PLACE ORDER BUTTON ===== */
        .place-order-btn {
            grid-column: span 2;
            padding: 18px;
            background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft), var(--blue-soft));
            color: #fff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .place-order-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }

        .place-order-btn:hover::before {
            left: 100%;
        }

        .place-order-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(91, 42, 134, 0.3);
            letter-spacing: 0.5px;
        }

        .place-order-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* ===== ERROR MESSAGES ===== */
        .error-message {
            color: var(--error);
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }

        .input-error {
            border-color: var(--error) !important;
        }

        /* ===== CONFIRM MODAL ===== */
        .confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .confirm-box {
            background: var(--white);
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 450px;
            text-align: center;
            box-shadow: var(--shadow-hard);
            animation: slideUp 0.4s ease;
            border: 1px solid var(--border-soft);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .confirm-box h3 {
            margin-bottom: 15px;
            color: var(--purple-dark);
            font-size: 1.5rem;
        }

        .confirm-box p {
            font-size: 1rem;
            color: var(--text-muted);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .confirm-actions {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .confirm-btn {
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--success), #059669);
            color: #fff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .confirm-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .cancel-btn {
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--error), #dc2626);
            color: #fff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }

        /* ===== LOADING ANIMATION ===== */
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--purple-soft);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .content-section {
                padding: 30px 20px;
                margin: 30px auto;
            }

            form {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .place-order-btn {
                grid-column: span 1;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .item-meta {
                justify-content: center;
                flex-wrap: wrap;
            }

            .back-btn-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }

            .back-btn-wrapper h2 {
                width: 100%;
                text-align: left;
            }

            .confirm-actions {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            h2 {
                font-size: 1.8rem;
            }

            h4 {
                font-size: 1.2rem;
            }

            .content-section {
                padding: 25px 15px;
            }

            .order-summary,
            .price-breakdown {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <section class="content-section">
        <!-- Back Button -->
        <div class="back-btn-wrapper">
            <a href="{{ route('customer.cart') }}" class="back-btn">
                <i class="fa fa-arrow-left"></i> Back to Cart
            </a>
            <h2>Checkout</h2>
        </div>

        <!-- Loyalty Info -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h3 style="color: var(--purple-dark); margin-bottom: 10px;">
                <i class="fas fa-crown" style="color: var(--gold);"></i> 
                Your Loyalty Status
            </h3>
            <p style="color: var(--text-muted); font-size: 1.1rem;">
                Total Orders: <span class="orders-count">{{ $ordersCount }}</span>
                @if($loyaltyDiscount > 0)
                    <span class="loyalty-badge">
                        <i class="fas fa-star"></i> {{ $loyaltyDiscount }}% OFF
                    </span>
                @endif
            </p>
           @if($loyaltySetting)
    @if($ordersCount > $loyaltySetting->min_orders)
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 5px;">
            Place {{ $loyaltySetting->min_orders - $ordersCount }} more order(s) to get 
            {{ $loyaltySetting->discount_percentage }}% discount!
        </p>
    @else
        <p style="color: var(--success); font-size: 0.9rem; margin-top: 5px;">
            <i class="fas fa-trophy"></i> Loyalty discount applied from this shop!
        </p>
    @endif
@endif

        </div>

        <!-- Order Summary -->
        <h4><i class="fas fa-shopping-bag"></i> Order Summary</h4>
        <div class="order-summary">
            @if($cartItems->count() > 0)
                <ul class="order-items">
                    @foreach($cartItems as $index => $item)
                    <li class="order-item">
                        @php
                            $productImage = $item->product->images->first()->image_path ?? $item->product->image_url;
                            $isOnSale = $item->product->is_on_sale;
                            $displayPrice = $isOnSale && $item->product->discount_value 
                                ? $item->product->discount_value 
                                : $item->product->price;
                            $itemTotal = $displayPrice * $item->quantity;
                        @endphp

                        @if($productImage)
                            <img src="{{ Str::startsWith($productImage, 'products/') ? asset('storage/'.$productImage) : asset($productImage) }}" 
                                 alt="{{ $item->product->product_name }}" 
                                 class="item-image">
                        @else
                            <div class="item-image" style="background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft)); display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif

                        <div class="item-details">
                            <div class="item-name">{{ $item->product->product_name }}</div>
                            <div class="item-meta">
                                <span>Quantity: <strong>{{ $item->quantity }}</strong></span>
                                @if($item->color)
                                    <span>Color: <strong>{{ $item->color }}</strong></span>
                                @endif
                                @if($item->size)
                                    <span>Size: <strong>{{ $item->size }}</strong></span>
                                @endif
                            </div>
                            <div class="item-price">
                                @if($isOnSale && $item->product->discount_value)
                                    <span class="sale-price">${{ number_format($item->product->discount_value, 2) }}</span>
                                    <span class="original-price">${{ number_format($item->product->price, 2) }}</span>
                                @else
                                    ${{ number_format($item->product->price, 2) }}
                                @endif
                                × {{ $item->quantity }} = 
                                <strong>${{ number_format($itemTotal, 2) }}</strong>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fas fa-shopping-cart" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <h3>Your cart is empty</h3>
                </div>
            @endif
        </div>

        <!-- Price Breakdown -->
        @php
            // Calculate subtotal using sale price if available
            $subtotal = 0;
            foreach($cartItems as $item) {
                $price = ($item->product->is_on_sale && $item->product->discount_value) 
                    ? $item->product->discount_value 
                    : $item->product->price;
                $subtotal += $price * $item->quantity;
            }

            // Calculate loyalty discount amount
            $loyaltyDiscountAmount = $subtotal * ($loyaltyDiscount / 100);

            // Calculate total after loyalty discount
            $totalAfterLoyalty = $subtotal - $loyaltyDiscountAmount;

            // Delivery cost will be added dynamically via JS
            $deliveryCost = 0; // Will be updated by JS
        @endphp

        <h4><i class="fas fa-receipt"></i> Price Breakdown</h4>
        <div class="price-breakdown">
            <div class="price-row">
                <span>Subtotal ({{ $cartItems->count() }} items)</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            
            @if($loyaltyDiscount > 0)
            <div class="price-row loyalty-discount">
                <span>Loyalty Discount ({{ $loyaltyDiscount }}%)</span>
                <span>-${{ number_format($loyaltyDiscountAmount, 2) }}</span>
            </div>
            @endif
            
            <div class="price-row">
                <span>Total after Discount</span>
                <span>${{ number_format($totalAfterLoyalty, 2) }}</span>
            </div>
            
            <div class="price-row delivery-cost" id="deliveryRow">
                <span>Delivery Cost</span>
                <span id="deliveryCost">$0.00</span>
            </div>
            
            <div class="price-row" id="finalTotalRow">
                <span>Final Total</span>
                <span id="finalTotal">${{ number_format($totalAfterLoyalty, 2) }}</span>
            </div>
        </div>

        <!-- Shipping Information -->
        <h4><i class="fas fa-truck"></i> Shipping Information</h4>
        <form action="{{ route('checkout.submit') }}" method="POST" id="checkoutForm">
            @csrf
            
            <!-- Hidden fields for price calculations -->
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
            <input type="hidden" name="loyalty_discount_percent" value="{{ $loyaltyDiscount }}">
            <input type="hidden" name="loyalty_discount_amount" value="{{ $loyaltyDiscountAmount }}">
            <input type="hidden" name="total_after_discount" value="{{ $totalAfterLoyalty }}">
            <input type="hidden" name="delivery_cost" id="deliveryCostInput" value="0">
            <input type="hidden" name="final_total" id="finalTotalInput" value="{{ $totalAfterLoyalty }}">

            <!-- Customer Info -->
            <div class="form-group">
                <label><i class="fas fa-user"></i> Full Name *</label>
                <input type="text" name="full_name" placeholder="Enter your full name" required 
                       value="{{ auth()->user()->name ?? '' }}">
                <span class="error-message" id="nameError"></span>
            </div>

            <div class="form-group">
                <label><i class="fas fa-phone"></i> Phone Number *</label>
                <input type="text" name="phone" placeholder="Enter your phone number" required>
                <span class="error-message" id="phoneError"></span>
            </div>

            <div class="form-group full-width">
                <label><i class="fas fa-map-marker-alt"></i> Shipping Address *</label>
                <textarea name="address" placeholder="Enter your complete shipping address" rows="3" required></textarea>
                <span class="error-message" id="addressError"></span>
            </div>

           

            <div class="form-group">
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
                <span class="error-message" id="deliveryError"></span>
            </div>

            <!-- Additional Information -->
            <div class="form-group full-width">
                <label><i class="fas fa-info-circle"></i> Additional Information (Optional)</label>
                <textarea name="additional_info" placeholder="Any special instructions or notes..." rows="2"></textarea>
            </div>

            <!-- Place Order Button -->
            <button type="button" class="place-order-btn" onclick="validateAndOpenConfirm()" 
                    {{ $cartItems->count() === 0 ? 'disabled' : '' }}>
                <i class="fas fa-lock"></i> 
                {{ $cartItems->count() === 0 ? 'Cart is Empty' : 'Place Order & Pay' }}
            </button>
        </form>
    </section>

    <!-- Loading Animation -->
    <div class="loading" id="loading">
        <div class="loading-spinner"></div>
        <p>Processing your order...</p>
    </div>

    <!-- Confirm Modal -->
    <div class="confirm-overlay" id="confirmOverlay">
        <div class="confirm-box">
            <h3><i class="fas fa-check-circle"></i> Confirm Your Order</h3>
            <p>Please review your order details before confirming. This action will process your payment and place the order.</p>
            
            <div class="price-summary" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 20px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span>Subtotal:</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                @if($loyaltyDiscount > 0)
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: var(--success);">
                    <span>Loyalty Discount ({{ $loyaltyDiscount }}%):</span>
                    <span>-${{ number_format($loyaltyDiscountAmount, 2) }}</span>
                </div>
                @endif
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: var(--purple-soft);">
                    <span>Delivery:</span>
                    <span id="confirmDeliveryCost">$0.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 1.1rem; color: var(--purple-dark); padding-top: 10px; border-top: 2px dashed #ddd;">
                    <span>Total:</span>
                    <span id="confirmTotal">${{ number_format($totalAfterLoyalty, 2) }}</span>
                </div>
            </div>
            
            <div class="confirm-actions">
                <button class="confirm-btn" onclick="submitCheckout()">
                    <i class="fas fa-check"></i> Confirm & Pay
                </button>
                <button class="cancel-btn" onclick="closeConfirm()">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        // Calculate total after discount
        const subtotal = parseFloat({{ $subtotal }});
        const loyaltyDiscountPercent = parseFloat({{ $loyaltyDiscount }});
        const loyaltyDiscountAmount = parseFloat({{ $loyaltyDiscountAmount }});
        let totalAfterDiscount = subtotal - loyaltyDiscountAmount;
        let deliveryCost = 0;
        let finalTotal = totalAfterDiscount;

        // Update delivery cost when selection changes
        function updateDeliveryCost() {
            const deliverySelect = document.getElementById('deliverySelect');
            const selectedOption = deliverySelect.options[deliverySelect.selectedIndex];
            
            if (selectedOption && selectedOption.value) {
                deliveryCost = parseFloat(selectedOption.dataset.cost) || 0;
            } else {
                deliveryCost = 0;
            }
            
            // Update display
            document.getElementById('deliveryCost').textContent = '$' + deliveryCost.toFixed(2);
            document.getElementById('confirmDeliveryCost').textContent = '$' + deliveryCost.toFixed(2);
            
            // Calculate final total
            finalTotal = totalAfterDiscount + deliveryCost;
            
            // Update display
            document.getElementById('finalTotal').textContent = '$' + finalTotal.toFixed(2);
            document.getElementById('confirmTotal').textContent = '$' + finalTotal.toFixed(2);
            
            // Update hidden fields
            document.getElementById('deliveryCostInput').value = deliveryCost;
            document.getElementById('finalTotalInput').value = finalTotal;
        }

        // Validate form before opening confirmation
        function validateAndOpenConfirm() {
            // Check if cart is empty
            if ({{ $cartItems->count() }} === 0) {
                alert('Your cart is empty. Please add items to your cart before checkout.');
                window.location.href = "{{ route('customer.cart') }}";
                return;
            }

            // Reset error states
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.style.display = 'none');
            
            const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
            inputs.forEach(input => input.classList.remove('input-error'));
            
            // Validate required fields
            let isValid = true;
            const fields = ['full_name', 'phone', 'address', 'payment_method_id', 'delivery_method_id'];
            
            fields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                const errorElement = document.getElementById(`${fieldName}Error`);
                
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('input-error');
                    if (errorElement) {
                        errorElement.textContent = 'This field is required';
                        errorElement.style.display = 'block';
                    }
                }
            });
            
            // Special validation for phone number
            const phoneField = document.querySelector('[name="phone"]');
            const phoneError = document.getElementById('phoneError');
            if (phoneField.value.trim() && !/^[\d\s\-\+\(\)]+$/.test(phoneField.value)) {
                isValid = false;
                phoneField.classList.add('input-error');
                phoneError.textContent = 'Please enter a valid phone number';
                phoneError.style.display = 'block';
            }
            
            if (!isValid) {
                // Scroll to first error
                const firstError = document.querySelector('.input-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            // Update delivery cost in modal
            updateDeliveryCost();
            
            // Show modal
            document.getElementById('confirmOverlay').style.display = 'flex';
        }

        // Close confirmation modal
        function closeConfirm() {
            document.getElementById('confirmOverlay').style.display = 'none';
        }

        // Submit checkout form
        function submitCheckout() {
            // Show loading
            document.getElementById('loading').style.display = 'block';
            document.getElementById('confirmOverlay').style.display = 'none';
            
            // Disable submit button to prevent double submission
            const submitBtn = document.querySelector('.place-order-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            // Submit form
            setTimeout(() => {
                document.getElementById('checkoutForm').submit();
            }, 1500);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDeliveryCost();
            document.getElementById('deliverySelect').addEventListener('change', updateDeliveryCost);

            // Add real-time validation
            const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('input-error');
                        const errorId = this.name + 'Error';
                        const errorElement = document.getElementById(errorId);
                        if (errorElement) {
                            errorElement.textContent = 'This field is required';
                            errorElement.style.display = 'block';
                        }
                    } else {
                        this.classList.remove('input-error');
                        const errorId = this.name + 'Error';
                        const errorElement = document.getElementById(errorId);
                        if (errorElement) {
                            errorElement.style.display = 'none';
                        }
                    }
                });
                
                input.addEventListener('input', function() {
                    this.classList.remove('input-error');
                    const errorId = this.name + 'Error';
                    const errorElement = document.getElementById(errorId);
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                });
            });
        });

        // Prevent form submission on Enter key in textarea
        document.getElementById('checkoutForm').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.tagName === 'TEXTAREA') {
                e.preventDefault();
            }
        });

        // Auto-fill name from user profile
        @if(auth()->check() && auth()->user()->name)
            document.querySelector('[name="full_name"]').value = "{{ auth()->user()->name }}";
        @endif
    </script>
</body>
</html>