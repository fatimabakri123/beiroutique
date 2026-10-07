@extends('admin.layout')
@section('title', 'Payment Methods')
@section('content')

<div class="container payment-methods-page">
    <div class="page-header">
        <h2>Payment Methods</h2>
        <p class="subtitle">Manage payment options available for customers</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Payment Methods List Card -->
            <div class="card methods-list-card">
                <div class="card-header">
                    <h5><i class="fas fa-credit-card"></i> Payment Methods</h5>
                    <span class="badge">{{ $methods->count() }} Methods</span>
                </div>
                
                <div class="card-body">
                    {{-- Flash messages --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if($methods->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-credit-card"></i>
                            <p>No payment methods added yet</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="payment-methods-table">
                                <thead>
                                    <tr>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($methods as $m)
                                        <tr class="{{ $m->is_active ? '' : 'inactive' }}">
                                            <td class="method-info">
                                                <div class="method-icon">
                                                    @if(str_contains(strtolower($m->method_name), 'cash'))
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    @elseif(str_contains(strtolower($m->method_name), 'card'))
                                                        <i class="fas fa-credit-card"></i>
                                                    @elseif(str_contains(strtolower($m->method_name), 'paypal'))
                                                        <i class="fab fa-paypal"></i>
                                                    @elseif(str_contains(strtolower($m->method_name), 'bank'))
                                                        <i class="fas fa-university"></i>
                                                    @else
                                                        <i class="fas fa-wallet"></i>
                                                    @endif
                                                </div>
                                                <div class="method-details">
                                                    <div class="method-name">{{ $m->method_name }}</div>
                                                    @if($m->method_name === 'Cash on Delivery')
                                                        <div class="method-note">Required method</div>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <td class="status-cell">
                                                <div class="status-indicator {{ $m->is_active ? 'active' : 'inactive' }}">
                                                    <span class="status-dot"></span>
                                                    <span class="status-text">{{ $m->is_active ? 'Active' : 'Inactive' }}</span>
                                                </div>
                                            </td>
                                            
                                            <td class="action-cell">
                                                @if($m->method_name === 'Cash on Delivery')
                                                    <span class="required-badge">
                                                        <i class="fas fa-lock"></i> Required
                                                    </span>
                                                @else
                                                    <form method="POST"
                                                          action="{{ route('admin.payment_methods.toggle', $m->payment_method_id) }}"
                                                          class="toggle-form">
                                                        @csrf
                                                        <button type="submit" class="btn-toggle {{ $m->is_active ? 'deactivate' : 'activate' }}">
                                                            <i class="fas fa-power-off"></i>
                                                            {{ $m->is_active ? 'Deactivate' : 'Activate' }}
                                                        </button>
                                                    </form>
                                                @endif
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
        
        <div class="col-lg-4">
            <!-- Add New Method Card -->
            <div class="card add-method-card">
                <div class="card-header">
                    <h5><i class="fas fa-plus-circle"></i> Add New Method</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payment_methods.store') }}" class="add-method-form">
                        @csrf
                        <div class="form-group">
                            <label for="method_name">Method Name</label>
                            <input type="text" 
                                   name="method_name" 
                                   id="method_name" 
                                   class="form-control" 
                                   placeholder="e.g. Credit Card, PayPal, Bank Transfer"
                                   required>
                            <div class="form-hint">Enter a clear name for the payment method</div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <label>Common Methods:</label>
                            <div class="common-methods">
                                <button type="button" class="common-method-btn" data-method="Credit Card">
                                    <i class="fas fa-credit-card"></i> Credit Card
                                </button>
                                <button type="button" class="common-method-btn" data-method="PayPal">
                                    <i class="fab fa-paypal"></i> PayPal
                                </button>
                                <button type="button" class="common-method-btn" data-method="Bank Transfer">
                                    <i class="fas fa-university"></i> Bank Transfer
                                </button>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-add-method">
                            <i class="fas fa-plus"></i> Add Payment Method
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="card stats-card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar"></i> Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ $methods->count() }}</div>
                            <div class="stat-label">Total Methods</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $methods->where('is_active', true)->count() }}</div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $methods->where('is_active', false)->count() }}</div>
                            <div class="stat-label">Inactive</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ====== VARIÁVEIS CSS ====== */
/* ====== VARIÁVEIS CSS ====== */
:root {
    --purple: #7b2fae;
    --purple-dark: #4b136e;
    --purple-light: #a05cd9;
    --purple-very-light: #f3edff;
    --blue: #5aa9ff;
    --blue-light: #1e90ff;
    --blue-lighter: #63b3ed;
    --pink: #ff6ec7;
    --red: #ff4757;
    --red-dark: #c44569;
    --green: #28a745;
    --green-light: #8FB996;
    --warning: #ffc107;
    --warning-light: #E6C7A8;
    --bg: #f7f8fc;
    --card: #ffffff;
    --text: #2c2f4a;
    --text-light: #8a8fa3;
    --border: #e1d9f3;
    --shadow: 0 5px 15px rgba(123, 47, 174, 0.1);
    --shadow-hover: 0 10px 25px rgba(123, 47, 174, 0.2);
    --radius: 12px;
    --card-radius: 15px;
}

/* ====== BASE ====== */
body {
    background: var(--bg);
    font-family: 'Poppins', sans-serif;
    color: var(--text);
}

.container.payment-methods-page {
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
    color: var(--primary-dark);
    margin-bottom: 8px;
    position: relative;
    display: inline-block;
}

.page-header h2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: 2px;
}

.page-header .subtitle {
    color: var(--text-light);
    font-size: 16px;
    font-weight: 500;
    margin-top: 15px;
}

/* ====== CARDS ====== */
.card {
    background: var(--light);
    border-radius: var(--card-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    margin-bottom: 25px;
    overflow: hidden;
}

.methods-list-card {
    border-top: 4px solid var(--primary);
    height: 100%;
}

.add-method-card {
    border-top: 4px solid var(--primary-light);
}

.stats-card {
    border-top: 4px solid var(--success);
}

.card-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, var(--primary-very-light), #FFFFFF);
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

/* ====== TABLE ====== */
.payment-methods-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.payment-methods-table thead {
    background: var(--primary-very-light);
}

.payment-methods-table th {
    padding: 16px 20px;
    text-align: left;
    font-size: 14px;
    font-weight: 700;
    color: var(--primary-dark);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--border);
}

.payment-methods-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: all 0.3s;
}

.payment-methods-table tbody tr:hover {
    background: var(--primary-very-light);
    transform: translateX(5px);
}

.payment-methods-table tbody tr.inactive {
    opacity: 0.7;
}

.payment-methods-table tbody tr.inactive:hover {
    opacity: 1;
}

.payment-methods-table td {
    padding: 18px 20px;
    vertical-align: middle;
}

/* ====== METHOD INFO CELL ====== */
.method-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.method-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-very-light), #FFFFFF);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border);
}

.method-icon i {
    font-size: 20px;
    color: var(--primary);
}

.method-details {
    flex: 1;
}

.method-name {
    font-weight: 600;
    color: var(--dark);
    font-size: 16px;
}

.method-note {
    font-size: 12px;
    color: var(--text-light);
    margin-top: 4px;
    font-style: italic;
}

/* ====== STATUS INDICATOR ====== */
.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.status-indicator.active {
    background: rgba(143, 185, 150, 0.2);
    color: #1f3d28;
}

.status-indicator.inactive {
    background: rgba(216, 166, 166, 0.2);
    color: #5c4636;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.status-indicator.active .status-dot {
    background: var(--success);
}

.status-indicator.inactive .status-dot {
    background: var(--danger);
}

/* ====== ACTION CELL ====== */
.action-cell {
    min-width: 140px;
}

.required-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: var(--primary-very-light);
    color: var(--primary-dark);
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.btn-toggle {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 120px;
    justify-content: center;
}

.btn-toggle.activate {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
}

.btn-toggle.deactivate {
    background: linear-gradient(135deg, var(--warning), #D4B28C);
    color: var(--dark);
}

.btn-toggle:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.toggle-form {
    margin: 0;
}

/* ====== ADD METHOD FORM ====== */
.add-method-form .form-group {
    margin-bottom: 20px;
}

.add-method-form label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--primary-dark);
    margin-bottom: 8px;
}

.add-method-form .form-control {
    border: 2px solid var(--border);
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 15px;
    transition: all 0.3s;
    background: white;
}

.add-method-form .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(139, 94, 60, 0.2);
    outline: none;
}

.form-hint {
    font-size: 12px;
    color: var(--text-light);
    margin-top: 5px;
}

.common-methods {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-top: 10px;
}

.common-method-btn {
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: white;
    color: var(--text);
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.common-method-btn:hover {
    background: var(--primary-very-light);
    border-color: var(--primary);
    transform: translateY(-2px);
}

.common-method-btn i {
    font-size: 16px;
    color: var(--primary);
}

.btn-add-method {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.btn-add-method:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

/* ====== STATS CARD ====== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    text-align: center;
}

.stat-item {
    padding: 15px;
    background: var(--primary-very-light);
    border-radius: 12px;
    border: 1px solid var(--border);
}

.stat-value {
    font-size: 24px;
    font-weight: 800;
    color: var(--primary-dark);
    margin-bottom: 5px;
}

.stat-label {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ====== ALERTS ====== */
.alert {
    padding: 15px 20px;
    border-radius: 12px;
    border: none;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: rgba(143, 185, 150, 0.2);
    color: #1f3d28;
    border-left: 4px solid var(--success);
}

.alert-danger {
    background: rgba(216, 166, 166, 0.2);
    color: #8B2C2C;
    border-left: 4px solid var(--danger);
}

.alert i {
    font-size: 18px;
}

.alert-success i {
    color: var(--success);
}

.alert-danger i {
    color: var(--danger);
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
    .row {
        flex-direction: column;
    }
    
    .col-lg-8, .col-lg-4 {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .container.payment-methods-page {
        padding: 0 15px;
    }
    
    .page-header h2 {
        font-size: 28px;
    }
    
    .common-methods {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .payment-methods-table {
        display: block;
        overflow-x: auto;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .method-info {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .page-header h2 {
        font-size: 24px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .btn-toggle {
        min-width: 100px;
        padding: 8px 12px;
        font-size: 13px;
    }
    
    .status-indicator {
        padding: 6px 12px;
        font-size: 13px;
    }
}

/* ====== JAVASCRIPT HELPER ====== */
<script>
document.addEventListener('DOMContentLoaded', function() {
    const commonBtns = document.querySelectorAll('.common-method-btn');
    const methodInput = document.getElementById('method_name');
    
    commonBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            methodInput.value = this.getAttribute('data-method');
            methodInput.focus();
        });
    });
});
</script>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection