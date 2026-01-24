@extends('admin.layout')
@section('title','Shop Owners')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Shop Owners</h5>
</div>
<div class="card p-2">
    <table class="table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Shops</th><th>Actions</th></tr></thead>
       <tbody>
@foreach ($owners as $owner)
    <tr>
        <td>{{ $owner->owner_id }}</td>

        <td>
            {{ $owner->user->name ?? 'No Name' }}
        </td>

        <td>
            {{ $owner->user->email ?? 'No Email' }}
        </td>

        <td>{{ $owner->shops_count }}</td>

       

        <td>
            <a href="{{ route('admin.shopowners.show', $owner->owner_id) }}" class="btn btn-sm btn-primary">View</a>
            <form action="{{ route('admin.shopowners.destroy', $owner->owner_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this shop owner?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
        </td>
    </tr>
@endforeach
</tbody>

    </table>
    {{ $owners->links() }}
</div>
@endsection
