@extends('admin.layout')
@section('title','System Settings')
@section('content')
<h5>System Settings</h5>
<div class="card p-3">
    <form method="POST" action="{{ route('admin.settings.save') }}">
        @csrf
        <div class="mb-2">
            <label>Site Name</label>
            <input name="site_name" class="form-control" value="{{ config('app.name') }}">
        </div>

        <div class="mb-2">
            <label>Default Currency</label>
            <input name="currency" class="form-control" value="{{ $settings['currency'] ?? 'USD' }}">
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</div>

<h6 class="mt-4">Payment Methods</h6>
<div class="card p-2">
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.payment_methods.index') }}">Manage Payment Methods</a>
</div>

<h6 class="mt-4">Delivery Methods</h6>
<div class="card p-2">
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.delivery_methods.index') }}">Manage Delivery Methods</a>
</div>
@endsection
