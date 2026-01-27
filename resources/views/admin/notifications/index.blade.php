@extends('admin.layout')
@section('title','Notifications')
@section('content')
<h3>Send Notification</h3>
<form method="POST" action="{{ route('notifications.send') }}">
    @csrf
    <label>Target</label>
    <select name="target" class="form-control">
        <option value="all">All</option>
        <option value="users">Users</option>
        <option value="customers">Customers</option>
        <option value="shop_owners">Shop Owners</option>
        <option value="user:1">User #1</option>
        <option value="customer:1">Customer #1</option>
        <option value="shop:1">Shop Owner #1</option>
    </select>

    <label>Title</label>
    <input type="text" name="title" class="form-control" required>

    <label>Message</label>
    <textarea name="message" class="form-control" required></textarea>

    <button type="submit" class="btn btn-primary mt-2">Send</button>
</form>


{{-- JS --}}
<script>
document.getElementById('targetSelect').addEventListener('change', function() {
    const specificDiv = document.getElementById('specificUserDiv');
    const input = document.getElementById('specificUserInput');
    
    if(this.value === 'user') {
        specificDiv.classList.remove('d-none');
        input.setAttribute('name', 'target');
        input.value = '';
    } else {
        specificDiv.classList.add('d-none');
        input.removeAttribute('name');
    }
});
</script>

{{-- CSS --}}
<style>
.notif-card {
    background: #f9f9f9;
    border-left: 4px solid #0d6efd;
    padding: 12px 15px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.notif-card p { margin: 6px 0; font-size: 14px; }
</style>
@endsection
