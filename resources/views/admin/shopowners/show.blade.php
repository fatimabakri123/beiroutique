@extends('admin.layout')
@section('title','Shop Owner Profile')
@section('content')

<div class="card p-3">

    {{-- Basic Info --}}
    <h4>{{ $owner->user->name }}</h4>
    <p>{{ $owner->user->email }} — {{ $owner->phone_number }}</p>

    

    {{-- Toggle Status Button --}}
 

    <hr>

    {{-- Stats --}}
    <h6 class="mt-3">Statistics</h6>
<ul>
    <li>Total Shops: {{ $owner->shops?->count() ?? 0 }}</li>
    <li>Total Products: {{ $owner->shops->sum(fn($s) => $s->products?->count() ?? 0) }}</li>
    <li>Total Orders: {{ $owner->shops->sum(fn($s) => $s->orders_count ?? 0) }}</li>
</ul>

<hr>

<h6 class="mt-3">Shops</h6>
<ul>
    @foreach($owner->shops as $s)
        <li>
            <strong>{{ $s->shop_name }}</strong> — 
            {{ $s->is_active ? 'Active' : 'Pending' }}  
            — Products: {{ $s->products?->count() ?? 0 }}
            — Orders: {{ $s->orders_count ?? 0 }}

            <a href="{{ route('admin.shops.show', $s->shop_id) }}" class="btn btn-sm btn-outline-primary ms-2">
                View Shop
            </a>
        </li>
    @endforeach
</ul>


    <hr>

    <a href="{{ route('admin.shopowners.index') }}" class="btn btn-outline-secondary">Back to Shop Owners</a>

</div>

@endsection
