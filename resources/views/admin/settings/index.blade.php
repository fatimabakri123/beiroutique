@extends('admin.layout')
@section('title','System Settings')
@section('content')
<h5>System Settings</h5>
<div class="card p-3">
  
<h6 class="mt-4">Payment Methods</h6>
<div class="card p-2">
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.payment_methods.index') }}">Manage Payment Methods</a>
</div>

<h6 class="mt-4">Delivery Methods</h6>
<div class="card p-2">
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.delivery_methods.index') }}">Manage Delivery Methods</a>
</div>
@endsection
