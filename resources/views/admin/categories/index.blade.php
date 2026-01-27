@extends('admin.layout')

@section('title','Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Categories</h3>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">+ Add Category</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->category_id }}</td>
                        <td>{{ $cat->category_name }}</td>
                        <td>{{ $cat->description ?? '-' }}</td>
                        <td>
                            @if($cat->image)
                                <img src="{{ asset('storage/'.$cat->image) }}" width="60">
                            @else
                                -
                            @endif
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('admin.categories.edit',$cat->category_id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form method="POST" action="{{ route('admin.categories.destroy',$cat->category_id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No categories found</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination inside card --}}
        @if ($categories->hasPages())
<div class="mt-3 d-flex justify-content-center">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($categories->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $categories->previousPageUrl() }}">&laquo;</a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
            <li class="page-item {{ $categories->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- Next Page Link --}}
        @if ($categories->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $categories->nextPageUrl() }}">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
</div>
@endif

    </div>

   <style>
/* ===== General Page Styling ===== */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f6f9;
    color: #333;
}

/* ===== Card Styling ===== */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    background-color: #fff;
}

/* ===== Table Styling ===== */
.table {
    border-collapse: separate;
    border-spacing: 0 8px;
    font-size: 16px;
}

.table thead {
    background-color: #0d6efd; /* nice blue */
    color: #fff;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
}

.table th, .table td {
    padding: 12px 15px;
    vertical-align: middle;
}

.table tbody tr {
    background-color: #ffffff;
    border-radius: 8px;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.table tbody tr:hover {
    background-color: #e6f0ff;
    transform: translateY(-2px);
}

/* ===== Images ===== */
.table img {
    border-radius: 6px;
    border: 1px solid #ddd;
}

/* ===== Buttons ===== */
.btn {
    font-size: 14px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    transition: 0.2s;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 13px;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0956d3;
    border-color: #0956d3;
    color: #fff;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #fff;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #e0a800;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #a71d2a;
    border-color: #a71d2a;
    color: #fff;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #565e64;
    border-color: #565e64;
}

/* ===== Pagination Styling ===== */
.pagination .page-item .page-link {
    color: #0d6efd;
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 6px 12px;
    margin: 0 2px;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

.pagination .page-item.disabled .page-link {
    color: #aaa;
}

/* ===== Headings ===== */
h3 {
    font-size: 28px;
    font-weight: 700;
    color: #0d6efd;
}
</style>

</div>
@endsection
