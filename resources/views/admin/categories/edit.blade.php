@extends('admin.layout')

@section('title','Edit Category')

@section('content')
<div class="edit-category-page">
    <h3>Edit Category</h3>

    <div class="card p-3">
        <form action="{{ route('admin.categories.update',$category->category_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" value="{{ $category->category_name }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $category->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Image</label>
                @if($category->image)
                    <img src="{{ Str::startsWith($category->image, 'http') ? $category->image : asset('storage/'.$category->image) }}" class="preview-image">
                @endif
                <input type="file" name="image" class="form-control">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        <style>
            /* ===== Edit Category Page ===== */
.edit-category-page {
    max-width: 650px;
    margin: 30px auto;
}

.edit-category-page h3 {
    text-align: center;
    font-size: 30px;
    font-weight: 700;
    color: #5e1cc0;
    margin-bottom: 20px;
}

/* Card */
.edit-category-page .card {
    border-radius: 18px;
    border: none;
    background: #fff;
    box-shadow: 0 10px 30px rgba(124,77,255,0.15);
}

/* Form groups */
.edit-category-page .form-group {
    margin-bottom: 15px;
}

.edit-category-page label {
    font-weight: 600;
    color: #4b2a85;
    margin-bottom: 5px;
    display: block;
}

/* Inputs */
.edit-category-page .form-control {
    border-radius: 10px;
    padding: 10px 12px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.edit-category-page .form-control:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 0.15rem rgba(124,77,255,0.25);
}

/* Image preview */
.preview-image {
    display: block;
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 8px;
    border: 1px solid #eee;
}

/* Buttons */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 15px;
}

.form-actions .btn-primary {
    background: linear-gradient(135deg, #7c3aed, #5e1cc0);
    border: none;
    border-radius: 10px;
    padding: 8px 18px;
    font-weight: 600;
}

.form-actions .btn-primary:hover {
    background: linear-gradient(135deg, #5e1cc0, #350799);
}

.form-actions .btn-secondary {
    border-radius: 10px;
    padding: 8px 18px;
    font-weight: 600;
}
</style>
    </div>
</div>
@endsection
