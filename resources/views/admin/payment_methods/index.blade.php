@extends('admin.layout')
@section('title','Payment Methods')

@section('content')
<h5 class="mb-3">💳 Payment Methods</h5>

<div class="card shadow-sm p-4">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add method --}}
    <form method="POST" action="{{ route('admin.payment_methods.store') }}" class="row g-2 mb-4">
        @csrf
        <div class="col-md-8">
            <input name="method_name" class="form-control" placeholder="e.g. Cash on Delivery" required>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">➕ Add Method</button>
        </div>
    </form>

    {{-- Methods list --}}
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Method</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($methods as $m)
                <tr>
                    <td>{{ $m->method_name }}</td>

                    <td>
                        @if($m->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Disabled</span>
                        @endif
                    </td>

                    <td class="text-end">
                        @if($m->method_name === 'Cash on Delivery')
                            <span class="text-muted">Required</span>
                        @else
                            <form method="POST"
                                  action="{{ route('admin.payment_methods.toggle', $m->payment_method_id) }}"
                                  class="d-inline">
                                @csrf
                                <button class="btn btn-sm {{ $m->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                    {{ $m->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<style>/* ===== Payment Methods Admin Style ===== */

:root {
    --brown-main: #8B5E3C;      /* rich brown */
    --brown-light: #C08A56;    /* caramel */
    --beige-bg: #F7F2ED;       /* soft beige */
    --beige-card: #FFF9F4;
    --text-dark: #4A3424;
}

/* Page title */
h5 {
    color: var(--brown-main);
    font-weight: 700;
}

/* Card */
.card {
    background: var(--beige-card);
    border-radius: 18px;
    border: none;
}

/* Table */
.table th {
    color: var(--brown-main);
    font-weight: 600;
    border-bottom: 2px solid #e6d6c8;
}

.table td {
    color: var(--text-dark);
    border-top: 1px solid #f0e4da;
}

/* Input */
input.form-control {
    border-radius: 12px;
    border: 1px solid #e3d1c2;
    padding: 10px 14px;
}

input.form-control:focus {
    border-color: var(--brown-light);
    box-shadow: 0 0 0 0.15rem rgba(192, 138, 86, 0.25);
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #8B5E3C, #C08A56);
    border: none;
    border-radius: 14px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #7A4F31, #B77945);
}

.btn-outline-warning {
    color: #8B5E3C;
    border-color: #8B5E3C;
    border-radius: 12px;
}

.btn-outline-warning:hover {
    background: #8B5E3C;
    color: #fff;
}

.btn-outline-success {
    color: #6A8E3F;
    border-color: #6A8E3F;
    border-radius: 12px;
}

.btn-outline-success:hover {
    background: #6A8E3F;
    color: #fff;
}

/* Badges */
.badge.bg-success {
    background: #8FB996 !important;
    color: #1f3d28;
    padding: 6px 10px;
    border-radius: 10px;
}

.badge.bg-secondary {
    background: #D8C6B8 !important;
    color: #5c4636;
    padding: 6px 10px;
    border-radius: 10px;
}

/* Alerts */
.alert-success {
    background: #E6F1EB;
    color: #2E6B4A;
    border-radius: 12px;
    border: none;
}

.alert-danger {
    background: #F8E4E4;
    color: #8B2C2C;
    border-radius: 12px;
    border: none;
}

/* Required text */
.text-muted {
    font-style: italic;
}

/* Smooth hover */
.table tr:hover {
    background: #FBF5EF;
    transition: 0.3s;
}
</style>
</div>
@endsection
