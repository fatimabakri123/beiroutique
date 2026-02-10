@extends('admin.layout')

@section('title', 'Subcategories')

@section('content')
<div class="container">
    <h2>Add New Subcategory</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.subcategories.store') }}">
        @csrf
        <div class="mb-3">
            <label>Subcategory Name</label>
            <input type="text" name="subcategory_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="add-btn">Add Subcategory</button>
    </form>

    <hr>

    <h4>All Subcategories</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subcategory</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $sub)
            <tr>
                <td>{{ $sub->subcategory_id }}</td>
                <td>{{ $sub->subcategory_name }}</td>
                <td>{{ $sub->category->category_name }}</td>
                <td>
               <a href="{{ route('admin.subcategories.edit', $sub->subcategory_id) }}" class="btn-edit">Edit</a>

<form action="{{ route('admin.subcategories.destroy', $sub->subcategory_id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this subcategory?')">
        Delete
    </button>
</form>


                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $subcategories->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
:root {
    --primary: #7b2fae;
    --bg-light: #f4f6fa;
    --card: #fff;
    --text: #2c3e50;
    --muted: #7f8c8d;
    --shadow: 0 6px 18px rgba(124,77,255,0.08);
    --shadow-hover: 0 10px 25px rgba(124,77,255,0.15);
}

h2 {
    color: var(--primary);
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 20px;
    position: relative;
}
h2::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background: var(--primary);
    border-radius: 2px;
    margin-top: 6px;
}

.container {
    max-width: 900px;
    margin: 30px auto;
    padding: 0 15px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

form {
    background: var(--card);
    padding: 20px 25px;
    border-radius: 16px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}
form:hover { transform: translateY(-3px); box-shadow: var(--shadow-hover); }
form .mb-3 label { font-weight: 600; color: var(--primary); margin-bottom: 5px; }
form .mb-3 input, form .mb-3 select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    width: 100%;
    font-size: 14px;
}
.add-btn {
    background: linear-gradient(135deg, #a080bc, #5b93c7);
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 10px 25px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.add-btn:hover { background: #6311ac; transform: translateY(-2px); }

.alert { border-radius: 12px; box-shadow: var(--shadow); }

table {
    width: 100%;
    background: var(--card);
    border-radius: 12px;
    box-shadow: var(--shadow);
    border-collapse: separate;
    border-spacing: 0;
}
table th, table td {
    padding: 12px 15px;
    text-align: left;
    font-size: 18px;
    color: var(--text);
}
table th { background: var(--bg-light); font-weight: 600; }
table tr:not(:last-child) { border-bottom: 1px solid #eee; }

.
.btn-warning { background: #f0ad4e; color: #fff; font-weight: 600; border: none; }
.btn-warning:hover { background: #ec9f3f; }
.btn-danger { background: #d9534f; color: #fff; }
.btn-danger:hover { background: #c9302c; }

@media(max-width:768px){
    table th, table td { font-size: 18px; padding: 10px; }
    form { padding: 15px; }
}
/* Edit Button */
.btn-edit {
    display: inline-block;
    background: linear-gradient(135deg, #f1c40f, #f39c12);
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    padding: 12px 28px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 18px rgba(241,196,15,0.3);
}
.btn-edit:hover {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(243,156,18,0.4);
}

/* Delete Button */
/* Delete Button */
.btn-delete {
    display: inline-block;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: #fff;
    font-weight: 700;
    font-size: 30px;
    padding: 12px 28px;
    border-radius: 12px;
    border: none; /* Important */
    cursor: pointer; /* Important */
    transition: all 0.3s ease;
    box-shadow: 0 6px 18px rgba(231,76,60,0.3);
    text-align: center; /* ensures proper text positioning */
     /* optional: makes it as big as Edit */
}
.btn-delete:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(231,76,60,0.5);
}



</style>
@endsection
