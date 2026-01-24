@extends('admin.layout')
@section('title','Pending Products')
@section('content')
<h5>Pending Products</h5>
<div class="card p-2">
    <table class="table">
    <thead><tr><th>Product</th><th>Shop</th><th>Submitted</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($pending as $p)
        <tr>
            <td>{{ $p->product_name }}</td>
            <td>{{ $p->shop->shop_name }}</td>
            <td>{{ $p->created_at->diffForHumans() }}</td>
            <td>
                <form method="POST" action="{{ route('admin.products.approve',$p->product_id) }}" style="display:inline">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
                <form method="POST" action="{{ route('admin.products.reject',$p->product_id) }}" style="display:inline">@csrf<button class="btn btn-sm btn-danger">Reject</button></form>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>
@endsection
