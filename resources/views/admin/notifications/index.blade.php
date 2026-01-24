@extends('admin.layout')
@section('title','Notifications')
@section('content')
<h5>Notifications</h5>

<div class="card p-3">
    {{-- Form لإرسال الإشعار --}}
    <form method="POST" action="{{ route('admin.notifications.send') }}">
        @csrf
        <div class="mb-2">
            <label>Target</label>
          <label>Target</label>
<select name="target_type" id="targetType" class="form-control">
    <option value="all">All Users</option>
    <option value="customers">Customers</option>
    <option value="shop_owners">Shop Owners</option>
    <option value="shop">Specific Shop</option>
    <option value="user">Specific User</option>
</select>
<div class="mb-2 d-none" id="userIdWrapper">
    <label>User ID</label>
    <input type="number" id="userIdInput" class="form-control" placeholder="Enter user ID">
</div>

<input type="hidden" name="target" id="finalTarget">
<script>
   
document.getElementById('targetType').addEventListener('change', function () {
    const userWrapper = document.getElementById('userIdWrapper');
    const finalTarget = document.getElementById('finalTarget');

    if (this.value === 'user') {
        userWrapper.classList.remove('d-none');
        finalTarget.value = '';
    } else {
        userWrapper.classList.add('d-none');
        finalTarget.value = this.value;
    }
});

document.getElementById('userIdInput')?.addEventListener('input', function () {
    document.getElementById('finalTarget').value = 'user:' + this.value;
});
</script>

        </div>

        <div class="mb-2">
            <label>Title</label>
            <input type="text" name="title" class="form-control" />

            <label>Message</label>
            <textarea name="message" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-primary">Send Notification</button>
    </form>

    <hr/>

    <h6 class="mt-3 d-flex justify-content-between align-items-center">
        Sent Notifications

        {{-- زر Delete All --}}
        /*<form method="POST" action="{{ route('admin.notifications.deleteAll') }}"
              onsubmit="return confirm('Are you sure you want to delete all Admin notifications?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete All Admin Notifications</button>
        </form>
    </h6>

    {{-- قائمة الإشعارات --}}
    <ul class="notification-list">
        @php $shown = []; @endphp

        @foreach($notifications as $index => $n)
            @php
                $data = json_decode($n->data, true);
                $message = $data['message'] ?? '';
            @endphp

            {{-- عرض كل رسالة مرة واحدة فقط --}}
            @if(!in_array($message, $shown))
                <li class="notification-item {{ $loop->index >= 3 ? 'd-none extra-notification' : '' }}">
                    <div class="notif-card d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $data['title'] ?? 'No title' }}</strong>
                            <p>{{ $message }}</p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}
                            </small>
                        </div>

                        {{-- Delete button --}}
                        <form method="POST" 
                              action="{{ route('admin.notifications.delete', $n->id) }}"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </li>
                @php $shown[] = $message; @endphp
            @endif
        @endforeach
    </ul>

    {{-- View More --}}
    @if(count($shown) > 3)
        <div class="text-center mt-3">
            <button id="viewMoreBtn" class="btn btn-outline-primary btn-sm">View more</button>
        </div>
    @endif
</div>

{{-- JS لزر View More --}}
<script>
document.getElementById('viewMoreBtn')?.addEventListener('click', function() {
    document.querySelectorAll('.extra-notification').forEach(el => el.classList.remove('d-none'));
    this.style.display = 'none';
});
</script>

{{-- CSS --}}
<style>
.notification-list { list-style: none; padding: 0; }
.notification-item { margin-bottom: 12px; }
.notif-card {
    background: #f9f9f9; 
    border-left: 4px solid #0d6efd; 
    padding: 12px 15px; 
    border-radius: 8px; 
    display: flex; 
    justify-content: space-between; 
}
.notif-card p { margin: 6px 0; font-size: 14px; }
</style>

@endsection
