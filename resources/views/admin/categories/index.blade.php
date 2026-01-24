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
/* Page header */
.d-flex h3 {
    font-weight: 700;
    color: #2c3e50;
}

/* Add button */
.btn-primary {
    background: #4f46e5;
    border: none;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 13px;
    color: #fff;
}

.btn-primary:hover {
    background: #4338ca;
}

/* Alerts */
.alert-success {
    border-radius: 10px;
    font-size: 14px;
    padding: 8px 15px;
}

/* Card */
.card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* Table */
.table {
    margin-bottom: 0;
}

.table thead th {
    font-size: 14px;
    font-weight: 600;
    color: #34495e;
    text-transform: uppercase;
}

.table tbody td {
    font-size: 14px;
    vertical-align: middle;
    color: #444;
}

/* Table rows hover */
.table tbody tr:hover {
    background: #f9fafb;
}

/* Images */
.table img {
    border-radius: 8px;
    border: 1px solid #eee;
}

/* Action buttons */
.table td .btn {
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 6px;
    border: none;
}

.btn-warning {
    background: #facc15;
    color: #000;
}

.btn-warning:hover {
    background: #eab308;
}

.btn-danger {
    background: #ef4444;
    color: #fff;
}

.btn-danger:hover {
    background: #dc2626;
}

/* Pagination */
.pagination {
    margin-top: 15px;
    justify-content: center;
    display: flex;
    padding: 10px 0;
}

.page-item .page-link {
    border-radius: 8px;
    margin: 0 3px;
    color: #4f46e5;
    border: 1px solid #ddd;
    font-size: 13px;
    padding: 5px 10px;
}

.page-item.active .page-link {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #fff;
}

.page-link:hover {
    background: #4338ca;
    color: #fff;
    border-color: #4338ca;
}

/* Responsive Table */
@media (max-width: 768px) {
    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        margin-bottom: 15px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        padding: 10px;
    }

    .table tbody td {
        display: block;
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    .table tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: 600;
        color: #555;
        text-transform: capitalize;
    }

    .table td.d-flex {
        justify-content: flex-end;
    }
}

    </style>
</div>
@endsection
