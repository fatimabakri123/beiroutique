@extends('admin.layout')
@section('content')
<div class="container">
    <h2>Edit Subcategory</h2>

    <form method="POST" action="{{ route('admin.subcategories.update', $subcategory->subcategory_id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Subcategory Name</label>
            <input type="text" name="subcategory_name" class="form-control" value="{{ $subcategory->subcategory_name }}" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ $subcategory->category_id == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

       <button type="submit" class="add-btn">Update Subcategory</button>
       <a href="{{ route('admin.subcategories') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
    <style>
/* ===== Container ===== */
.container {
    max-width: 600px;
    margin: 50px auto;
    background: #fff;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

.container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

/* ===== Heading ===== */
.container h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #5b2a86;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* ===== Form Inputs ===== */
.form-control {
    width: 100%;
    padding: 12px 15px;
    margin-top: 8px;
    margin-bottom: 20px;
    border: 2px solid #ddd;
    border-radius: 10px;
    outline: none;
    transition: 0.3s;
    font-size: 15px;
}

.form-control:focus {
    border-color: #5b2a86;
    box-shadow: 0 0 5px rgba(91,42,134,0.5);
}

/* ===== Labels ===== */
label {
    font-weight: 500;
    color: #333;
}

/* ===== Buttons ===== */
.add-btn, .btn-secondary {
    padding: 12px 25px;
    border: none;
    border-radius: 50px;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    margin-top: 10px;
}

/* ===== Primary Button ===== */
.add-btn {
    background: linear-gradient(135deg, #5b2a86, #1f7bb8);
    color: #fff;
    box-shadow: 0 6px 15px rgba(91,42,134,0.3);
}

.add-btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(91,42,134,0.4);
}

/* ===== Secondary Button ===== */
.btn-secondary {
    background: #ddd;
    color: #555;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn-secondary:hover {
    background: #bbb;
    color: #fff;
    transform: translateY(-2px);
}

/* ===== Select Menu ===== */
select.form-control {
    appearance: none;
    background: url('data:image/svg+xml;utf8,<svg fill="gray" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 15px center;
    background-color: #fff;
    background-size: 12px;
}

/* ===== Input Animation ===== */
input, select {
    transition: all 0.3s ease;
}

/* ===== Responsive ===== */
@media (max-width: 600px) {
    .container {
        margin: 20px;
        padding: 30px 20px;
    }
}
</style>

</div>
@endsection
