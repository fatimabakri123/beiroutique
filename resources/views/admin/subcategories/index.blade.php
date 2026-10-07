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
    <table class="table mt-3">
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
                    <div class="action-buttons">
                        <!-- Edit -->
                        <a href="{{ route('admin.subcategories.edit', $sub->subcategory_id) }}" class="icon-btn edit-btn">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('admin.subcategories.destroy', $sub->subcategory_id) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn delete-btn" onclick="return confirm('Are you sure you want to delete this subcategory?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
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
    --purple: #7b2fae;
    --purple-dark: #4b136e;
    --pink: #5c0c75;
    --blue: #1e90ff;
    --red: #ff4757;
    --bg: #f7f8fc;
    --text: #2c2f4a;
    --muted: #8a8fa3;
}

/* ====== BODY ====== */
body {
    background: var(--bg);
    font-family: 'Poppins', sans-serif;
}

/* ====== HEADERS ====== */
h2 {
    font-size: 38px;
    font-weight: 800;
    text-align: center;
    background: linear-gradient(135deg, var(--purple), var(--pink));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 25px;
}

h4 {
    font-size: 28px;
    font-weight: 700;
    color: var(--purple-dark);
    margin-bottom: 20px;
}

/* ====== CONTAINER ====== */
.container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 30px;
    background: transparent;
    border-radius: 24px;
}

/* ====== FORM ====== */
form {
    padding: 30px;
    margin-bottom: 40px;
}

form label {
    font-size: 15px;
    font-weight: 700;
    color: var(--purple-dark);
    margin-bottom: 8px;
    display: block;
}

form input,
form select {
    border-radius: 12px;
    padding: 12px;
    font-size: 15px;
    border: 2px solid #e1d9f3;
    transition: 0.3s;
    width: 100%;
}
form input:focus,
form select:focus {
    border-color: var(--purple);
    box-shadow: 0 0 0 3px rgba(123,47,174,0.2);
    outline: none;
}

/* ====== ADD BUTTON ====== */
.add-btn {
    margin-top: 10px;
    background: linear-gradient(135deg, var(--purple), var(--pink));
    border: none;
    color: white;
    font-size: 18px;
    font-weight: 700;
    padding: 14px 40px;
    border-radius: 50px;
    cursor: pointer;
    transition: 0.3s;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.add-btn:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 10px 25px rgba(123,47,174,0.4);
}

/* ====== TABLE ====== */
table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    background: linear-gradient(135deg, var(--purple), var(--blue));
    color: white;
    padding: 16px;
    border-radius: 12px;
    text-align: center;
    font-size: 18px;
}

tbody tr {
    background: transparent;
    transition: 0.3s;
}

tbody td {
    padding: 16px;
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    border: none;
}

/* ====== ACTION BUTTONS (SEM FUNDO) ====== */
.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    align-items: center;
}

/* ÍCONES SEM FUNDO */
.icon-btn {
    background: none !important; /* Remove qualquer fundo */
    border: none !important;
    padding: 8px !important;
    cursor: pointer;
    transition: 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    text-decoration: none;
}

/* Edit Icon - Apenas ícone azul */
.edit-btn i {
    color: var(--blue);
    font-size: 20px;
    transition: 0.3s;
}

.edit-btn:hover i {
    color: #0056b3;
    transform: scale(1.2);
}

.edit-btn:hover {
    background: rgba(30, 144, 255, 0.1) !important;
}

/* Delete Icon - Apenas ícone vermelho */
.delete-btn i {
    color: var(--red);
    font-size: 20px;
    transition: 0.3s;
}

.delete-btn:hover i {
    color: #c1121f;
    transform: scale(1.2);
}

.delete-btn:hover {
    background: rgba(255, 71, 87, 0.1) !important;
}

/* ====== ALERTS ====== */
.alert-success {
    background: linear-gradient(135deg, #00b894, #00a085);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #ff7675, #d63031);
    color: white;
}

/* ====== PAGINATION ====== */
.pagination {
    justify-content: center;
}

.pagination .page-link {
    border-radius: 50%;
    margin: 0 4px;
    border: none;
    color: var(--purple);
    font-weight: 700;
    padding: 10px 16px;
    transition: 0.3s;
}
.pagination .page-link:hover {
    background: var(--bg);
}
.pagination .active .page-link {
    background: var(--purple);
    color: #fff;
}

/* ====== HR ====== */
hr {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, var(--purple), var(--pink));
    margin: 40px 0;
    opacity: 0.3;
}

/* ====== MOBILE ====== */
@media(max-width:768px){
    h2 { font-size: 28px; }
    h4 { font-size: 22px; }
    tbody td { font-size: 14px; }
    .action-buttons {
        flex-direction: column;
        gap: 10px;
    }
}
</style>

{{-- Font Awesome Icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection