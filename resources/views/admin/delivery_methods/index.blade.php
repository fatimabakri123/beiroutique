@extends('admin.layout')
@section('title','Delivery Methods')
@section('content')

<div class="container delivery-page">
    <div class="page-header">
        <h2>Delivery Methods</h2>
        <p class="subtitle">Manage shipping and delivery options for your store</p>
    </div>

    <!-- Add New Method Card -->
    <div class="card add-method-card">
        <div class="card-header">
            <h5><i class="fas fa-plus-circle"></i> Add New Delivery Method</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.delivery_methods.store') }}" class="delivery-form">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="method_name">Method Name</label>
                            <input type="text" 
                                   name="method_name" 
                                   id="method_name" 
                                   class="form-control" 
                                   placeholder="e.g. Standard Shipping" 
                                   required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cost">Cost ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       name="cost" 
                                       id="cost" 
                                       class="form-control" 
                                       placeholder="0.00" 
                                       step="0.01" 
                                       min="0"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estimated_time">Estimated Time</label>
                            <input type="text" 
                                   name="estimated_time" 
                                   id="estimated_time" 
                                   class="form-control" 
                                   placeholder="e.g. 3-5 business days" 
                                   required>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn-add-method">
                            <i class="fas fa-plus"></i> Add Method
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delivery Methods List -->
    <div class="card methods-list-card">
        <div class="card-header">
            <h5><i class="fas fa-shipping-fast"></i> Delivery Methods List</h5>
            <span class="badge">{{ $methods->count() }} Methods</span>
        </div>
        <div class="card-body">
            @if($methods->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-truck"></i>
                    <p>No delivery methods added yet</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="delivery-methods-table">
                        <thead>
                            <tr>
                                <th>Method Name</th>
                                <th>Cost</th>
                                <th>Estimated Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($methods as $m)
                            <tr class="{{ $m->is_active ? '' : 'inactive' }}">
                                <td class="method-name">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>{{ $m->method_name }}</span>
                                </td>
                                <td class="cost">
                                    <span class="price">${{ number_format($m->cost, 2) }}</span>
                                </td>
                                <td class="time">
                                    <i class="far fa-clock"></i>
                                    <span>{{ $m->estimated_time }}</span>
                                </td>
                                <td class="status">
                                    <span class="status-badge {{ $m->is_active ? 'active' : 'inactive' }}">
                                        <i class="fas fa-circle"></i>
                                        {{ $m->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="actions">
                                    <form method="POST" 
                                          action="{{ route('admin.delivery_methods.toggle', $m->delivery_method_id) }}" 
                                          class="toggle-form">
                                        @csrf
                                        <button type="submit" class="btn-toggle">
                                            <i class="fas fa-power-off"></i>
                                            Toggle Status
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* ====== VARIÁVEIS CSS ====== */
:root {
    --primary: #7b2fae;
    --primary-dark: #4b136e;
    --primary-light: #a05cd9;
    --primary-very-light: #f3edff;
    --secondary: #6c757d;
    --success: #28a745;
    --danger: #dc3545;
    --warning: #ffc107;
    --info: #17a2b8;
    --light: #f8f9fa;
    --dark: #343a40;
    --bg: #f7f8fc;
    --text: #2c2f4a;
    --text-light: #8a8fa3;
    --border: #e1d9f3;
    --shadow: 0 5px 15px rgba(123, 47, 174, 0.1);
    --shadow-hover: 0 10px 25px rgba(123, 47, 174, 0.2);
    --radius: 12px;
    --card-radius: 15px;
    --btn-radius: 8px;
}

/* ====== RESET & BASE ====== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: var(--bg);
    font-family: 'Poppins', sans-serif;
    color: var(--text);
    line-height: 1.6;
}

/* ====== CONTAINER ====== */
.container.delivery-page {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

/* ====== PAGE HEADER ====== */
.page-header {
    margin-bottom: 30px;
    text-align: center;
}

.page-header h2 {
    font-size: 32px;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
}

.page-header .subtitle {
    color: var(--text-light);
    font-size: 16px;
    font-weight: 500;
}

/* ====== CARDS ====== */
.card {
    background: white;
    border-radius: var(--card-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    margin-bottom: 30px;
    overflow: hidden;
}

.add-method-card {
    border-top: 4px solid var(--primary);
}

.methods-list-card {
    border-top: 4px solid var(--primary-light);
}

.card-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, var(--primary-very-light), #ffffff);
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h5 {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header h5 i {
    color: var(--primary);
}

.card-header .badge {
    background: var(--primary);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.card-body {
    padding: 25px;
}

/* ====== FORM ====== */
.delivery-form .form-group {
    margin-bottom: 0;
}

.delivery-form label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--primary-dark);
    margin-bottom: 8px;
}

.delivery-form .form-control {
    border: 2px solid var(--border);
    border-radius: var(--btn-radius);
    padding: 12px 15px;
    font-size: 15px;
    transition: all 0.3s;
    height: 48px;
}

.delivery-form .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(123, 47, 174, 0.2);
    outline: none;
}

.delivery-form .input-group {
    height: 48px;
}

.delivery-form .input-group-text {
    background: var(--primary-very-light);
    border: 2px solid var(--border);
    border-right: none;
    color: var(--primary);
    font-weight: 600;
}

/* ====== ADD METHOD BUTTON ====== */
.btn-add-method {
    width: 100%;
    height: 48px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
    border: none;
    border-radius: var(--btn-radius);
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-add-method:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.btn-add-method:active {
    transform: translateY(0);
}

/* ====== TABLE ====== */
.delivery-methods-table {
    width: 100%;
    border-collapse: collapse;
}

.delivery-methods-table thead {
    background: linear-gradient(135deg, var(--primary-very-light), #f8f5ff);
}

.delivery-methods-table th {
    padding: 15px 20px;
    text-align: left;
    font-size: 14px;
    font-weight: 700;
    color: var(--primary-dark);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--border);
}

.delivery-methods-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: all 0.3s;
}

.delivery-methods-table tbody tr:hover {
    background: var(--primary-very-light);
}

.delivery-methods-table tbody tr.inactive {
    opacity: 0.7;
    background: #f8f9fa;
}

.delivery-methods-table tbody tr.inactive:hover {
    background: #f0f1f3;
}

.delivery-methods-table td {
    padding: 18px 20px;
    vertical-align: middle;
}

/* ====== TABLE CELL STYLES ====== */
.method-name {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
    color: var(--text);
}

.method-name i {
    color: var(--primary);
    font-size: 18px;
}

.cost .price {
    font-weight: 700;
    color: var(--success);
    font-size: 18px;
}

.time {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text-light);
}

.time i {
    color: var(--info);
}

/* ====== STATUS BADGE ====== */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.active {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.status-badge.inactive {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger);
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.status-badge i {
    font-size: 8px;
}

/* ====== TOGGLE BUTTON ====== */
.btn-toggle {
    background: linear-gradient(135deg, var(--warning), #ffb347);
    color: white;
    border: none;
    border-radius: var(--btn-radius);
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
}

.btn-toggle:active {
    transform: translateY(0);
}

.toggle-form {
    margin: 0;
}

/* ====== EMPTY STATE ====== */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    color: var(--text-light);
}

.empty-state i {
    font-size: 60px;
    color: var(--border);
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state p {
    font-size: 18px;
    font-weight: 500;
}

/* ====== RESPONSIVO ====== */
@media (max-width: 992px) {
    .container.delivery-page {
        max-width: 100%;
        padding: 0 15px;
    }
}

@media (max-width: 768px) {
    .page-header h2 {
        font-size: 28px;
    }
    
    .delivery-form .row {
        flex-direction: column;
    }
    
    .delivery-form .col-md-4,
    .delivery-form .col-md-3,
    .delivery-form .col-md-2 {
        width: 100%;
        margin-bottom: 15px;
    }
    
    .delivery-form .col-md-2.d-flex {
        margin-bottom: 0;
    }
    
    .delivery-methods-table {
        display: block;
        overflow-x: auto;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .card-header .badge {
        align-self: flex-start;
    }
}

@media (max-width: 480px) {
    .page-header h2 {
        font-size: 24px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .delivery-methods-table th,
    .delivery-methods-table td {
        padding: 12px 15px;
    }
    
    .btn-toggle {
        padding: 8px 12px;
        font-size: 13px;
    }
}

/* ====== ANIMAÇÕES ====== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.add-method-card {
    animation: fadeIn 0.4s ease-out;
}

.methods-list-card {
    animation: fadeIn 0.6s ease-out;
}

.delivery-methods-table tbody tr {
    animation: fadeIn 0.3s ease-out;
    animation-fill-mode: both;
}

.delivery-methods-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
.delivery-methods-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
.delivery-methods-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
.delivery-methods-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
.delivery-methods-table tbody tr:nth-child(5) { animation-delay: 0.5s; }
</style>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection