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
        <style>
            /* ===== Add Category Page ===== */
h3 {
    text-align: center;
    font-size: 30px;
    font-weight: 700;
    color: #5e1cc0;
    margin-bottom: 20px;
}

.card {
    max-width: 650px;
    margin: 0 auto;
    border-radius: 18px;
    border: none;
    background: #fff;
    box-shadow: 0 10px 30px rgba(124,77,255,0.15);
}

/* Labels */
.form-label {
    font-weight: 600;
    color: #4b2a85;
}

/* Inputs */
.form-control {
    border-radius: 10px;
    padding: 10px 12px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.form-control:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 0.15rem rgba(124,77,255,0.25);
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #7c3aed, #5e1cc0);
    border: none;
    border-radius: 10px;
    padding: 8px 18px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5e1cc0, #350799);
}

.btn-secondary {
    border-radius: 10px;
    padding: 8px 18px;
    font-weight: 600;
}
</style>
    </form>
</div>
@endsection
