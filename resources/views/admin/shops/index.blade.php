@extends('admin.layout')
@section('title','Shops')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>Shops</h5>
</div>

<div class="shops-list">

    @foreach($shops as $s)
    <div class="shop-card">
        <div class="shop-info">
            <div class="avatar">{{ strtoupper(substr($s->shop_name ?? 'S',0,1)) }}</div>
            <div class="details">
                <h6>{{ $s->shop_name }}</h6>
                <p>Owner: {{ $s->owner->user->name ?? '-' }}</p>
                <p>Products: <strong>{{ $s->products_count ?? 0 }}</strong></p>
                <p>Status: 
                    <strong>{{ $s->is_active ? 'Active' : 'Inactive' }}</strong>
                </p>
            </div>
        </div>

      <div class="shop-actions">
    {{-- Toggle Status --}}
    <form action="{{ route('status.toggle', $s->shop_id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" 
            class="btn {{ $s->is_active ? 'btn-danger' : 'btn-success' }}">
            {{ $s->is_active ? 'Deactivate' : 'Activate' }}
        </button>
    </form>

    {{-- View --}}
    <a href="{{ route('admin.shops.show',$s->shop_id) }}" class="btn btn-view">View</a>

    {{-- Approve if not active --}}
    @if(!$s->is_active)
        <form action="{{ route('admin.shops.approve',$s->owner_id) }}" method="POST">
            @csrf
            <button class="btn btn-approve">Approve</button>
        </form>
    @endif

    {{-- Remove Shop --}}
    <form action="{{ route('admin.shops.destroy', $s->shop_id) }}" method="POST" 
          onsubmit="return confirm('Are you sure you want to remove this shop?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-remove">Remove</button>

    </form>
</div>
    </div>
    @endforeach
   <div class="pagination-custom">
    @if($shops->onFirstPage())
        <span class="btn btn-secondary btn-sm disabled">Previous</span>
    @else
        <a href="{{ $shops->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
    @endif

    @if($shops->hasMorePages())
        <a href="{{ $shops->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
    @else
        <span class="btn btn-secondary btn-sm disabled">Next</span>
    @endif
</div>
    
</div>

<style>
/* ===== LIST WRAPPER ===== */
.shops-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* ===== SHOP CARD ===== */
.shop-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 18px 22px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(124,77,255,0.08);
    transition: all 0.3s ease;
}
.shop-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 35px rgba(124,77,255,0.18);
}

/* ===== SHOP INFO ===== */
.shop-info {
    display: flex;
    align-items: center;
    gap: 15px;
}
.shop-info .avatar {
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
.shop-info .details h6 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #6311ac;
}
.shop-info .details p {
    margin: 2px 0;
    font-size: 16px;
    color: #410872;
}

/* ===== ACTIONS ===== */
.shop-actions {
    display: flex;
    gap: 10px;
}
.shop-actions form, .shop-actions a {
    display: inline-block;
}
.btn-view, .btn-approve, .btn-success, .btn-danger {
    font-size: 18px;
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
.btn-approve, .btn-success {
    border-color: #16a34a;
    color: #16a34a;
    background: transparent;
}
.btn-approve:hover, .btn-success:hover {
    background: #16a34a;
    color: #fff;
    box-shadow: 0 6px 20px rgba(22,163,74,0.4);
    transform: translateY(-2px) scale(1.05);
}
.btn-danger {
    border-color: #3a0fb0;
    color: #5426dc;
    background: transparent;
}
.btn-danger:hover {
    background: #7349c6;
    color: #fff;
    box-shadow: 0 6px 20px rgba(53, 38, 220, 0.51);
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
    .shop-card { flex-direction: column; align-items: flex-start; }
    .shop-actions { margin-top: 10px; width: 100%; justify-content: flex-start; gap: 8px; }
}
/* ===== CUSTOM PAGINATION (PREV / NEXT) ===== */
.pagination-custom {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin-top: 30px;
}

.pagination-custom .btn {
    min-width: 110px;
    height: 40px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
}

/* Active buttons */
.pagination-custom .btn-primary {
    background: linear-gradient(135deg, #7b2fae, #a64dd1);
    color: #fff;
    box-shadow: 0 6px 18px rgba(124,77,255,0.35);
}

.pagination-custom .btn-primary:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 10px 25px rgba(124,77,255,0.45);
}

/* Disabled buttons */
.pagination-custom .btn-secondary {
    background: #eee;
    color: #aaa;
    cursor: not-allowed;
}
/* ===== REMOVE BUTTON ===== */
.btn-remove {
    background: linear-gradient(135deg, #dc2626, #f43f5e);
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(220,38,38,0.35);
    transition: all 0.25s ease;
}

.btn-remove:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 10px 25px rgba(220,38,38,0.45);
}

.btn-remove:active {
    transform: scale(0.96);
}


</style>

@endsection
