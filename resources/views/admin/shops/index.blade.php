@extends('admin.layout')
@section('title','Shops')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Shops</h5>
</div>
<div class="card p-2">
    <table class="table">
        <thead><tr><th>ID</th><th>Shop Name</th><th>Owner</th><th>Status</th><th>Products</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($shops as $s)
            <tr>
                <td>{{ $s->shop_id }}</td>
                <td>{{ $s->shop_name }}</td>
                <td>{{ $s->owner->user->name?? '-' }}</td>
               <td>
    <form action="{{ route('status.toggle', $s->shop_id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" 
            class="btn {{ $s->is_active ? 'btn-danger' : 'btn-success' }}">
            {{ $s->is_active ? 'Deactivate' : 'Activate' }}
        </button>
    </form>
</td>

                <td>{{ $s->products_count ?? 0 }}</td>
                <td>
                    <a href="{{ route('admin.shops.show',$s->shop_id) }}" class="btn btn-sm btn-outline-primary">View</a>
                    @if(!$s->is_active)
                        <form action="{{ route('admin.shops.approve',$s->owner_id) }}" method="POST" style="display:inline">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $shops->links() }}
</div>
@endsection
