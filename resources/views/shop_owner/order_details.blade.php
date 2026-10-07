<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #{{ $order->order_id }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <style>
:root {
   --purple-dark: #5b2a86;
   --purple-soft: #1f7bb8eb;
   --blue-soft: #8f3f9beb;

   --bg-light: #fdfcff;
   --white: #ffffff;

   --text-dark: #1e1b4b;
   --text-muted: #6b7280;

   --border-soft: rgba(226,232,240,0.8);
   --shadow-soft: 0 18px 40px rgba(91, 42, 134, 0.18);
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--bg-light);
    color: var(--text-dark);
    margin: 0;
    padding: 0;
}

.dashboard-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
}

/* ===== BACK BUTTON STYLES ===== */
.back-btn-wrapper {
    margin-bottom: 25px;
    width: 100%;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: var(--white);
    font-weight: 600;
    font-size: 16px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(91, 42, 134, 0.25);
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.back-btn i {
    font-size: 16px;
    transition: transform 0.3s ease;
}

.back-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(91, 42, 134, 0.35);
    background: linear-gradient(135deg, var(--purple-soft), var(--purple-dark));
    color: var(--white);
}

.back-btn:hover i {
    transform: translateX(-5px);
}

.back-btn:active {
    transform: translateY(0);
    box-shadow: 0 5px 15px rgba(91, 42, 134, 0.25);
}

/* Alternative Simple Back Button */
.back-btn-simple {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--purple-dark);
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 30px;
    transition: all 0.3s ease;
    background: var(--white);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.back-btn-simple:hover {
    background: rgba(91, 42, 134, 0.08);
    color: var(--purple-dark);
    transform: translateX(-5px);
}

.back-btn-simple i {
    font-size: 16px;
}

/* Table */
.table-container {
    background: var(--white);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: var(--shadow-soft);
}

.table-container h3 {
    margin-bottom: 15px;
    color: var(--purple-dark);
    font-size: 20px;
    border-left: 4px solid var(--purple-dark);
    padding-left: 10px;
}

.table-container p {
    margin: 8px 0;
    font-size: 18px;
}

.table-container p strong {
    color: var(--purple-dark);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table th, table td {
    padding: 12px;
    border-bottom: 1px solid var(--border-soft);
    font-size: 18px;
}

table th {
    background-color: var(--purple-dark);
    color: var(--white);
    text-align: left;
    border-radius: 4px;
}

.status-select {
    padding: 8px 14px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    color: #fff;
    min-width: 140px;
    text-transform: capitalize;
    font-size: 16px;
}

.status-select.pending { background-color: var(--purple-dark); }
.status-select.processing { background-color: var(--purple-soft); }
.status-select.shipped { background-color: var(--blue-soft); }
.status-select.delivered { background-color: #A67C52; }
.status-select.cancelled { background-color: #452dcd; }

.add-btn {
    display: inline-block;
    padding: 12px 22px;
    background-color: var(--purple-dark);
    color: var(--white);
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    font-size: 16px;
}

.add-btn:hover {
    background-color: var(--purple-soft);
}

/* Header with Back Button */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.page-header h2 {
    margin: 0;
    color: var(--purple-dark);
}

/* Animation */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.back-btn, .back-btn-simple {
    animation: slideInLeft 0.5s ease;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 15px;
    }
    
    .back-btn-wrapper {
        margin-bottom: 20px;
    }
    
    .back-btn, .back-btn-simple {
        padding: 10px 20px;
        font-size: 15px;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="order-details-page">
    <div class="dashboard-container">

        {{-- OPTION 1: Back Button at the very top (Choose ONE of these options) --}}
        
        {{-- Option A: Gradient Back Button --}}
        <div class="back-btn-wrapper">
            <a href="{{ route('shop.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        {{-- Option B: Simple Back Button (Comment out Option A and uncomment this if you prefer) --}}
        {{--
        <div class="back-btn-wrapper">
            <a href="{{ route('shop.dashboard') }}" class="back-btn-simple">
                <i class="fas fa-arrow-left"></i> ← Back to Dashboard
            </a>
        </div>
        --}}

        {{-- OR Option C: Header with integrated back button --}}
        {{--
        <div class="page-header">
            <h2>Order #{{ $order->order_id }}</h2>
            <a href="{{ route('shop.dashboard') }}" class="back-btn-simple">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        --}}

        {{-- Customer Info --}}
        <div class="table-container">
            <h3>Customer Info</h3>
            <p><strong>Name:</strong> {{ $order->full_name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            @php use Illuminate\Support\Str; @endphp

           <p><strong>Address:</strong></p>

@php
    $lines = explode("\n", $order->shipping_address);
    $lat = null;
    $lng = null;
@endphp

@foreach($lines as $line)
    @if(Str::startsWith(trim($line), 'Location:'))
        @php
            $coords = str_replace('Location:', '', $line);
            [$lat, $lng] = array_map('trim', explode(',', $coords));
        @endphp
    @else
        <p>{{ $line }}</p>
    @endif
@endforeach

@if($lat && $lng)
    <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}"
       target="_blank"
       style="color:#C08A56; font-weight:600;">
        📍 Open Location on Google Maps
    </a>
@endif

            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->paymentMethod->method_name) }}</p>
            <p><strong>Delivery Method:</strong> {{ ucfirst($order->deliveryMethod->method_name) }}</p>
        </div>

        {{-- Order Status --}}
        <div class="table-container">
            <h3>Order Status</h3>

            <form action="{{ route('shop.orders.updateStatus', $order->order_id) }}" method="POST">
                @csrf
                @method('PUT')

                <select name="order_status"
                        id="statusSelect"
                        class="status-select {{ $order->order_status }}">
                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                        <option value="{{ $status }}"
                            {{ $order->order_status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="add-btn">Update Status</button>
            </form>
        </div>

        {{-- Products --}}
        <div class="table-container">
            <h3>Products Bought From Your Shop</h3>

            <table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Color</th>
            <th>Size</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->color ?? '-' }}</td>
                <td>{{ $item->size ?? '-' }}</td>
                <td>${{ $item->price_at_purchase }}</td>
                <td>${{ $item->quantity * $item->price_at_purchase }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

            <h3 style="text-align:right;margin-top:20px;">
                Total: ${{ number_format($total, 2) }}
            </h3>
        </div>

        {{-- Bottom Back Button (Optional - remove if you already have top button) --}}
        {{--
        <div class="back-btn-wrapper" style="margin-top: 20px;">
            <a href="{{ route('shop.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        --}}

    </div>
</div>

{{-- JS for live status color update --}}
<script>
    const statusSelect = document.getElementById('statusSelect');

    function updateStatusClass() {
        statusSelect.className = 'status-select ' + statusSelect.value;
    }

    statusSelect.addEventListener('change', updateStatusClass);
    updateStatusClass();
</script>  
</body> </html>