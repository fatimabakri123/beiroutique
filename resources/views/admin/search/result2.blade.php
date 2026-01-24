@extends('layouts.app')

@section('title','Search results')

@section('content')
<h3>Search results for "{{ $q }}"</h3>

<h4>Products</h4>
@if($products->count())
    <ul>
    @foreach($products as $p)
        <li>{{ $p->product_name }} - {{ $p->shop->name }} (Category: {{ $p->category->name }})</li>
    @endforeach
    </ul>
@else
    <p>No products found.</p>
@endif

<h4>Categories</h4>
@if($categories->count())
    <ul>
    @foreach($categories as $c)
        <li>{{ $c->name }}</li>
    @endforeach
    </ul>
@else
    <p>No categories found.</p>
@endif

<h4>Shops</h4>
@if($shops->count())
    <ul>
    @foreach($shops as $s)
        <li>{{ $s->name }}</li>
    @endforeach
    </ul>
@else
    <p>No shops found.</p>
@endif
@endsection
