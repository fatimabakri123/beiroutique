@extends('admin.layout')

@section('title','Add Category')

@section('content')
<h3>Add New Category</h3>

<div class="card p-3">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="category_name" class="form-control" required>
            @error('category_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
