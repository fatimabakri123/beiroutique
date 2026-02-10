@extends('admin.layout')
@section('title','Shop Owners')
@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>Shop Owners</h5>
</div>

<div class="owners-list">

    @foreach ($owners as $owner)
    <div class="owner-card">
        <div class="owner-info">
            <div class="avatar">{{ strtoupper(substr($owner->user->name ?? 'U',0,1)) }}</div>
            <div class="details">
                <h6>{{ $owner->user->name ?? 'No Name' }}</h6>
                <p>{{ $owner->user->email ?? 'No Email' }}</p>
                <p>Shops: <strong>{{ $owner->shops_count }}</strong></p>
              <p>Shop names: <strong>
    {{ $owner->shops->pluck('shop_name')->implode(', ') ?: 'N/A' }}
</strong></p>

            </div>
        </div>
        <div class="owner-actions">
            <a href="{{ route('admin.shopowners.show', $owner->owner_id) }}" class="btn btn-view">View</a>
            <form action="{{ route('admin.shopowners.destroy', $owner->owner_id) }}" method="POST" onsubmit="return confirm('Delete this shop owner?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
            </form>
        </div>
    </div>
    @endforeach

  
   <div class="pagination-custom">
    @if($owners->onFirstPage())
        <span class="btn btn-secondary btn-sm disabled">Previous</span>
    @else
        <a href="{{ $owners->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
    @endif

    @if($owners->hasMorePages())
        <a href="{{ $owners->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
    @else
        <span class="btn btn-secondary btn-sm disabled">Next</span>
    @endif
</div>
</div>

<style>
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
    font-size: 18px;
    font-weight: 800;
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

/* ===== LIST WRAPPER ===== */
.owners-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* ===== OWNER CARD ===== */
.owner-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 15px 20px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(124,77,255,0.08);
    transition: all 0.3s ease;
}
.owner-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(124,77,255,0.18);
}

/* ===== OWNER INFO ===== */
.owner-info {
    display: flex;
    align-items: center;
    gap: 15px;
}
.owner-info .avatar {
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
.owner-info .details h6 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #6311ac;
}
.owner-info .details p {
    margin: 2px 0;
    font-size: 16px;
    color: #440e5d;
}

/* ===== ACTIONS ===== */
.owner-actions {
    display: flex;
    gap: 10px;
}
.btn-view, .btn-delete {
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
.btn-delete {
    border-color: #dc2626;
    color: #dc2626;
    background: transparent;
}
.btn-delete:hover {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 6px 20px rgba(220,38,38,0.4);
    transform: translateY(-2px) scale(1.05);
}

/* ===== CLEAN LARAVEL PAGINATION ===== */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 25px;
}

.pagination .page-item {
    margin: 0 4px;
}

.pagination .page-link {
    min-width: 34px;
    height: 34px;
    padding: 0 8px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #7b2fae;
    background: #f6effb;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* SVG arrows */
.pagination .page-link svg {
    width: 14px !important;
    height: 14px !important;
}

.pagination .page-link:hover {
    background: #7b2fae;
    color: #fff;
}

.pagination .active .page-link {
    background: #7b2fae;
    color: #fff;
}

.pagination .disabled .page-link {
    background: #eee;
    color: #aaa;
}


</style>

@endsection
