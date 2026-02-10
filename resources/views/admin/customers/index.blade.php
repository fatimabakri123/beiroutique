@extends('admin.layout')
@section('title','Customers')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>Customers</h5>
</div>

<div class="customers-list">

    @foreach($customers as $c)
    <div class="customer-card">
        <div class="customer-info">
            <div class="avatar">{{ strtoupper(substr($c->user->name ?? 'U',0,1)) }}</div>
            <div class="details">
                <h6>{{ $c->user->name ?? 'No Name' }} {{ $c->user->last_name ?? '' }}</h6>
                <p>{{ $c->user->email ?? 'No Email' }}</p>
                <p>Phone: {{ $c->phone_number ?? 'N/A' }}</p>
                <p>Orders: <strong>{{ $c->orders_count ?? 0 }}</strong></p>
                <p>Shops: <strong>
                    {{
                        $c->orders
                            ->flatMap(fn($order) => $order->items)
                            ->pluck('product.shop.shop_name')
                            ->filter()
                            ->unique()
                            ->implode(', ') ?: 'N/A'
                    }}
                </strong></p>
            </div>
        </div>

        <div class="customer-actions">
            <a href="{{ route('admin.customers.show',$c->customer_id) }}" class="btn btn-view">View</a>
            <form action="{{ route('admin.customers.destroy',$c->customer_id) }}" method="POST" onsubmit="return confirm('Delete this customer?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </div>
    </div>
    @endforeach

    {{ $customers->links() }}
</div>

<style>
/* ===== LIST WRAPPER ===== */
.customers-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* ===== CUSTOMER CARD ===== */
.customer-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 18px 22px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(124,77,255,0.08);
    transition: all 0.3s ease;
}
.customer-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 35px rgba(124,77,255,0.18);
}

/* ===== CUSTOMER INFO ===== */
.customer-info {
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 14px;
}
.customer-info .avatar {
    width: 50px;
    height: 50px;
    background: #7b2fae;
    border-radius: 50%;
    color: #fff;
    font-weight: 700;
    font-size: 22px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.customer-info .details h6 {
    margin: 0;
    font-size: 18px;
    font-weight: 800;
    color: #6311ac;
}
.customer-info .details p {
    margin: 2px 0;
    font-size: 16px;
    color: #440e5d;
}

/* ===== ACTIONS ===== */
.customer-actions {
    display: flex;
    gap: 10px;
}
.btn-view, .btn-delete {
    font-size: 13px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 12px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-view {
    border-color: #7b2fae;
    color: #7b2fae;
    background: transparent;
    font-size: 18px;
}

.btn-view:hover {
    background: linear-gradient(135deg,#7b2fae,#a64dd1);
    color: #fff;
    box-shadow: 0 8px 22px rgba(124,77,255,0.4);
    transform: translateY(-2px) scale(1.05);
}
.btn-delete {
    border-color: #dc2626;
    color: #dc2626;
    background: transparent;
    font-size: 18px;
}
.btn-delete:hover {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 6px 20px rgba(220,38,38,0.4);
    transform: translateY(-2px) scale(1.05);
}

/* ===== PAGINATION ===== */
.pagination .page-link {
    border-radius: 10px;
    border: none;
    margin: 0 3px;
    color: #7b2fae;
}
.pagination .active .page-link {
    background: #7b2fae;
    color: #fff;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .customer-card { flex-direction: column; align-items: flex-start; }
    .customer-actions { margin-top: 10px; width: 100%; justify-content: flex-start; gap: 8px; }
}
</style>

@endsection
