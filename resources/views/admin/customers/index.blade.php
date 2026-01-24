@extends('admin.layout')
@section('title','Customers')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5>Customers</h5>
   
</div>
<a href="{{ route('admin.customers.export', ['shop_id' => $shopId]) }}"
   class="btn btn-success mb-2">
   Export Excel
</a>


<div class="card p-2">
    <form method="GET" class="d-flex gap-2 mb-3">
    <select name="shop_id" class="form-select w-auto" onchange="this.form.submit()">
        <option value="">All Shops</option>
        @foreach($shops as $shop)
            <option value="{{ $shop->shop_id }}"
                {{ $shopId == $shop->shop_id ? 'selected' : '' }}>
                {{ $shop->shop_name }}
            </option>
        @endforeach
    </select>

    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
        Reset
    </a>
</form>

    <table class="table table-hover">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Shop</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($customers as $c)
            <tr>
                <td>{{ $c->customer_id }}</td>
              <td>{{ $c->user->name }} {{ $c->user->last_name }}</td>
                <td>{{ $c->user->email }}</td>
<td>{{ $c->phone_number }}</td>
<td>{{ $c->orders_count }}</td>
<td>
    {{
        $c->orders
            ->flatMap(fn($order) => $order->items)
            ->pluck('product.shop.shop_name')
            ->filter()
            ->unique()
            ->implode(', ')
        ?: 'N/A'
    }}
</td>

               
                <td>
                    <a href="{{ route('admin.customers.show',$c->customer_id) }}" class="btn btn-sm btn-outline-primary">View</a>
                    <form action="{{ route('admin.customers.destroy',$c->customer_id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $customers->links() }}
</div>
@endsection
