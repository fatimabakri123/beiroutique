@extends('admin.layout')

@section('title','Categories')

@section('content')
<div class=" mb-3">
    <h3>Categories</h3>
   <a href="{{ route('admin.categories.create') }}" class="btn add-btn">
    + Add Category
</a>

</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="categories-list">

    @forelse($categories as $cat)
    <div class="category-card">
        <div class="category-info">
            <div class="category-image">
                @if($cat->image)
                    <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->category_name }}">
                @else
                    <div class="placeholder">No Image</div>
                @endif
            </div>
            <div class="category-details">
                <h5>{{ $cat->category_name }}</h5>
                <p>{{ $cat->description ?? 'No description' }}</p>
            </div>
        </div>
        <div class="category-actions">
            <a href="{{ route('admin.categories.edit',$cat->category_id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form method="POST" action="{{ route('admin.categories.destroy',$cat->category_id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <p class="text-center text-muted">No categories found</p>
    @endforelse

  @if ($categories->hasPages())
<div class="mt-3 d-flex justify-content-center">
    {{ $categories->links('pagination::simple-bootstrap-4') }}
</div>
@endif

</div>

<style>
    .add-btn {
    background: linear-gradient(135deg, #7c3aed, #5e1cc0);
    color: #fff !important;
    padding: 10px 22px;
    font-size: 15px;
    font-weight: 600;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(124,77,255,0.3);
    transition: all 0.3s ease;
    text-decoration: none;
}

.add-btn:hover {
    background: linear-gradient(135deg, #5e1cc0, #350799);
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 10px 25px rgba(124,77,255,0.45);
}

    .btn a{
        font-size:16px;
    }
  h3 {
    color: #5e1cc0e1;
    text-align: center; 
}

   .category-actions a{
    color:#ffff;
   }
.category-actions .btn-warning {
    background-color: #5e1cc0cc; 
    border-color: #0d6dfd2f;
    padding: 8px 16px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 10px;
}

.category-actions .btn-warning:hover {
    background-color: #3817b0ce;
    border-color: #0a57ca71;
}

.category-actions .btn-danger {
    background-color: #dc3545; 
    border-color: #dc3545;
    padding: 8px 16px; 
    font-size: 14px;
    font-weight: 600;
    border-radius: 10px;
}

.category-actions .btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

/* ===== Categories List ===== */
.categories-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* ===== Single Category Card ===== */
.category-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    border-radius: 14px;
    padding: 15px 20px;
    box-shadow: 0 8px 25px rgba(124,77,255,0.08);
    transition: all 0.3s ease;
}
.category-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(124,77,255,0.18);
}

.category-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.category-image img {
    width:100px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #eee;
}

.category-image .placeholder {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 12px;
}

.category-details h5 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #6311ac;
}

.category-details p {
    margin: 2px 0;
    font-size: 16px;
    color: #555;
}

/* Actions */
.category-actions {
    display: flex;
    gap: 8px;
}

/* Buttons */
.btn-sm {
    padding: 5px 10px;
    font-size: 13px;
    border-radius: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .category-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .category-actions {
        width: 100%;
        justify-content: flex-start;
    }
}
</style>
@endsection
