@extends('admin.layout')

@section('title','Edit Category')

@section('content')
<h3>Edit Category</h3>

<div class="card p-3">
    <form action="{{ route('admin.categories.update',$category->category_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="category_name" class="form-control" value="{{ $category->category_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label><br>
            @if($category->image)
                <img src="{{Str::startsWith($category->image, 'http') ? $category->image : asset('storage/'.$category->image) }}" width="80" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
