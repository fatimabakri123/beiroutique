@extends('shop_owner.layout')

@section('title', 'Notifications')
@section('content')

@php
    $notifications = auth()->user()->notifications;
    $productIds = $notifications->pluck('data.product_id')->filter()->unique();
    $products = \App\Models\products::whereIn('product_id', $productIds)->get()->keyBy('product_id');
@endphp

<div class="dashboard-container">
    <h2 class="notifications-title">Notifications</h2>

    @if($notifications->isEmpty())
        <div class="empty-notifications">
            <p>No notifications yet.</p>
        </div>
    @else
        <div class="notifications-list">
            @foreach($notifications as $n)
                @php
                    $type = $n->data['type'] ?? 'unknown';
                    $productId = $n->data['product_id'] ?? null;
                    $orderId = $n->data['order_id'] ?? null;
                    $product = $productId && isset($products[$productId]) ? $products[$productId] : null;
                    $productName = $product ? $product->product_name : ($n->data['product_name'] ?? 'Unknown Product');
                    $productImage = $product 
                        ? ($product->images()->exists() ? asset('storage/' . $product->images()->first()->image_path) : asset('storage/' . $product->image_url))
                        : ($n->data['image'] ?? asset('default-product.png'));

                    // Determine link and button text based on notification type
                  $linkUrl = '#';
$buttonText = 'View';

if ($type === 'new_order' && $orderId) {
    // Add return_to parameter for orders
    $linkUrl = route('shop.orders.show', ['order' => $orderId, 'return_to' => 'notifications']);
    $buttonText = 'View Order';
} elseif ($type === 'product_report' && $productId) {
    $linkUrl = route('product.show', $productId);
    $buttonText = 'View Details';
}
                @endphp

                <div class="notification-card {{ $n->read_at ? 'read' : 'unread' }}" id="notification-{{ $n->id }}">
                    <div class="notification-image">
                        <img src="{{ $productImage }}" alt="{{ $productName }}">
                        @if(!$n->read_at)
                            <span class="unread-badge" id="badge-{{ $n->id }}"></span>
                        @endif
                    </div>
                    
                    <div class="notification-content">
                        <h4 class="notification-title">
                            {{ $productName }}
                            @if($type === 'new_order' && !$n->read_at)
                                <span class="notification-type-badge new-order" id="type-badge-{{ $n->id }}">New Order</span>
                            @elseif($type === 'new_order' && $n->read_at)
                                <span class="notification-type-badge read-order">Order</span>
                            @elseif($type === 'product_report')
                                <span class="notification-type-badge product-report">Product Report</span>
                            @endif
                        </h4>
                        
                        <div class="notification-message">
                            @if($type === 'new_order')
                                {{ $n->data['message'] ?? 'A new order has been placed.' }}
                            @elseif($type === 'product_report')
                                {{ $n->data['message'] ?? 'New issue reported.' }}
                            @else
                                {{ $n->data['message'] ?? 'Unknown notification type.' }}
                            @endif
                        </div>
                        
                        @if($type === 'new_order' && $orderId)
                            <div class="notification-detail">
                                <i class="fas fa-receipt"></i> Order ID: <strong>{{ $orderId }}</strong>
                            </div>
                        @endif
                        
                        @if($type === 'product_report')
                            <div class="notification-details">
                                @if($orderId)
                                    <div class="notification-detail">
                                        <i class="fas fa-receipt"></i> Order ID: <strong>{{ $orderId }}</strong>
                                    </div>
                                @endif
                                @if($n->data['issue_type'] ?? false)
                                    <div class="notification-detail">
                                        <i class="fas fa-exclamation-triangle"></i> Issue: <strong>{{ $n->data['issue_type'] }}</strong>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <div class="notification-time">
                            <i class="far fa-clock"></i> {{ $n->created_at ? $n->created_at->diffForHumans() : '' }}
                        </div>
                    </div>
                    
                  <div class="notification-actions">
    @if($type === 'new_order' && $orderId)
        <a href="{{ route('shop.orders.show', ['order' => $orderId, 'return_to' => 'notifications']) }}" class="btn-view">
            <i class="fas fa-eye"></i> View Order
        </a>
    @elseif($type === 'product_report' && $productId)
        <a href="{{ route('product.show', $productId) }}" class="btn-view">
            <i class="fas fa-eye"></i> View Details
        </a>
    @else
        <a href="{{ $linkUrl }}" class="btn-view">
            <i class="fas fa-eye"></i> {{ $buttonText }}
        </a>
    @endif
    
    @if(!$n->read_at)
        <button type="button" onclick="markAsRead('{{ $n->id }}')" class="btn-mark-read" id="mark-read-btn-{{ $n->id }}">
            <i class="fas fa-check"></i> Mark Read
        </button>
    @endif
</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* Keep all your existing CSS styles, just add this new class */
.notification-type-badge.read-order {
    background: rgba(107, 114, 128, 0.15);
    color: var(--text-muted);
    border: 1px solid rgba(107, 114, 128, 0.3);
}
</style>

<script>
function markAsRead(notificationId) {
    // Show loading state
    const button = document.getElementById(`mark-read-btn-${notificationId}`);
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Marking...';
    button.disabled = true;
    
    // Make AJAX request
    fetch(`/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Update UI without page reload
            const notificationCard = document.getElementById(`notification-${notificationId}`);
            const unreadBadge = document.getElementById(`badge-${notificationId}`);
            const typeBadge = document.getElementById(`type-badge-${notificationId}`);
            
            // Remove unread badge
            if (unreadBadge) unreadBadge.style.display = 'none';
            
            // Change "New Order" badge to just "Order"
            if (typeBadge) {
                typeBadge.textContent = 'Order';
                typeBadge.className = 'notification-type-badge read-order';
            }
            
            // Remove border and background
            notificationCard.classList.remove('unread');
            notificationCard.classList.add('read');
            
            // Remove Mark Read button
            button.style.display = 'none';
            
            // Optional: Show success message
            showToast('Notification marked as read');
        } else {
            // Restore button if error
            button.innerHTML = originalText;
            button.disabled = false;
            alert('Error marking notification as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = originalText;
        button.disabled = false;
        alert('Network error. Please try again.');
    });
}

function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-message';
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--success);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    
    // Add animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    
    // Add to page
    document.body.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
:root {
    --primary: #5b2a86;
    --secondary: #1f7bb8eb;
    --accent: #8f3f9beb;
    --bg-light: #f5f7fb;
    --white: #ffffff;
    --text-dark: #1e1b4b;
    --text-muted: #6b7280;
    --border-soft: rgba(226,232,240,0.8);
    --shadow-soft: 0 12px 30px rgba(91, 42, 134, 0.15);
    --success: #1cc88a;
    --warning: #f6c23e;
    --danger: #e74a3b;
    --info: #36b9cc;
}

.dashboard-container {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 20px;
    box-sizing: border-box;
}

/* Page title - Bigger like dashboard */
.notifications-title {
    font-size: 2.2rem; /* Increased font size */
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--border-soft);
}

.empty-notifications {
    background: var(--white);
    padding: 40px;
    border-radius: 14px;
    text-align: center;
    box-shadow: var(--shadow-soft);
}

.empty-notifications p {
    font-size: 1.3rem; /* Increased font size */
    color: var(--text-muted);
    margin: 0;
}

/* Notification card */
.notification-card {
    display: flex;
    align-items: center;
    background: var(--white);
    padding: 25px 30px; /* Increased padding */
    margin-bottom: 20px;
    border-radius: 14px;
    box-shadow: var(--shadow-soft);
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.notification-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(91, 42, 134, 0.2);
}

.notification-card.unread {
    border-left-color: var(--secondary);
    background: linear-gradient(to right, rgba(31, 123, 184, 0.03), var(--white));
}

/* Notification image */
.notification-image {
    position: relative;
    margin-right: 25px;
}

.notification-card img {
    width: 100px; /* Increased size */
    height: 100px; /* Increased size */
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid var(--border-soft);
}

.unread-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 12px;
    height: 12px;
    background: var(--secondary);
    border-radius: 50%;
    border: 2px solid var(--white);
}

/* Notification content */
.notification-content {
    flex: 1;
}

.notification-title {
    font-size: 1.4rem; /* Increased font size */
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 10px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.notification-type-badge {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.notification-type-badge.new-order {
    background: rgba(28, 200, 138, 0.15);
    color: var(--success);
    border: 1px solid rgba(28, 200, 138, 0.3);
}

.notification-type-badge.product-report {
    background: rgba(246, 194, 62, 0.15);
    color: var(--warning);
    border: 1px solid rgba(246, 194, 62, 0.3);
}

.notification-message {
    font-size: 1.1rem; /* Increased font size */
    color: var(--text-dark);
    margin-bottom: 12px;
    line-height: 1.5;
}

.notification-details {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 12px;
}

.notification-detail {
    font-size: 1rem; /* Increased font size */
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
}

.notification-detail i {
    color: var(--secondary);
    font-size: 0.9rem;
}

.notification-detail strong {
    color: var(--text-dark);
    font-weight: 600;
}

.notification-time {
    font-size: 0.95rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
}

.notification-time i {
    color: var(--accent);
}

/* Notification actions */
.notification-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-left: 20px;
}

.btn-view {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px; /* Increased padding */
    background: linear-gradient(135deg, var(--secondary), var(--accent));
    color: var(--white);
    border-radius: 8px;
    text-decoration: none;
    font-size: 1rem; /* Increased font size */
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    text-align: center;
    min-width: 140px;
}

.btn-view:hover {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(91, 42, 134, 0.2);
}

.btn-mark-read {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px; /* Increased padding */
    background: var(--bg-light);
    color: var(--text-muted);
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.95rem; /* Increased font size */
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid var(--border-soft);
    cursor: pointer;
    text-align: center;
    min-width: 140px;
}

.btn-mark-read:hover {
    background: var(--white);
    color: var(--secondary);
    border-color: var(--secondary);
}

/* Responsive design */
@media (max-width: 768px) {
    .notification-card {
        flex-direction: column;
        align-items: flex-start;
        padding: 20px;
    }
    
    .notification-image {
        margin-right: 0;
        margin-bottom: 15px;
    }
    
    .notification-actions {
        flex-direction: row;
        margin-left: 0;
        margin-top: 15px;
        width: 100%;
    }
    
    .btn-view,
    .btn-mark-read {
        flex: 1;
        justify-content: center;
    }
    
    .notification-title {
        font-size: 1.3rem;
    }
    
    .notification-message {
        font-size: 1rem;
    }
}
</style>

@endsection