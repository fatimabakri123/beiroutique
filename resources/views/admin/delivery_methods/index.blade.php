@extends('admin.layout')
@section('title','Delivery Methods')
@section('content')
<h5>Delivery Methods</h5>
<div class="card p-3">
    <form method="POST" action="{{ route('admin.delivery_methods.store') }}">
        @csrf
        <div class="mb-2"><input name="method_name" class="form-control" placeholder="Method name e.g. Standard Shipping"></div>
        <div class="mb-2"><input name="cost" class="form-control" placeholder="Cost"></div>
        <div class="mb-2"><input name="estimated_time" class="form-control" placeholder="Estimated time"></div>
        <button class="btn btn-sm btn-primary">Add</button>
    </form>

    <ul class="mt-3">
        @foreach($methods as $m)
            <li>{{ $m->method_name }} — {{ $m->cost }} — {{ $m->estimated_time }}
                <form method="POST" action="{{ route('admin.delivery_methods.toggle',$m->delivery_method_id) }}" style="display:inline">@csrf<button class="btn btn-sm btn-link">Toggle</button></form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
