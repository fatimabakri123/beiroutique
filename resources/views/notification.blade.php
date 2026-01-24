@extends('layouts.customer')

@section('content')
<section id="notifications" class="content-section active">
  <h2>Notifications</h2>

  @if($notifications->count() > 0)
  <ul class="notification-list">
   @foreach($notifications as $note)
<a href="{{ $note->data['url'] ?? '#' }}" class="notification-link">
<li class="notification-item {{ $note->read_at ? '' : 'unread' }}">

{{-- IMAGE OR ICON --}}
@if(($note->data['type'] ?? '') === 'product')
    <div class="notif-img">
        <img src="{{ asset('storage/' . $note->data['image']) }}" alt="Product">
    </div>
@else
    <div class="notif-icon">🔥</div>
@endif


    {{-- CONTENT --}}
    <div class="notif-content">
        <h4>{{ $note->data['title'] }}</h4>
        <p>{{ $note->data['message'] }}</p>
        <small>{{ $note->created_at->diffForHumans() }}</small>
    </div>

</li>
</a>
@endforeach

  </ul>
  @else
  <p>No notifications available.</p>
  @endif
</section>

<style>
/* 🔔 NOTIFICATION STYLES — STEP 4 */
.notification-list {
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.notification-link {
  text-decoration: none;
  color: inherit;
}

.notification-item {
  display: flex;
  align-items: center;
  gap: 15px;
  background: #fff;
  border-radius: 14px;
  padding: 15px;
  margin-bottom: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
  transition: 0.3s ease;
}

.notification-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.notification-item.unread {
  border-left: 5px solid #C08A56;
  background: #fff7f0;
}

.notif-img img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 10px;
}

.notif-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg,#ff7a18,#ffb347);
  color: white;
  font-size: 26px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notif-content h4 {
  font-size: 15px;
  margin-bottom: 4px;
}

.notif-content p {
  font-size: 14px;
  color: #555;
}

.notif-content small {
  font-size: 12px;
  color: #999;
}
</style>

@endsection