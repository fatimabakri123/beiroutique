@extends('layouts.customer')

@section('content')
<section id="notifications" class="content-section active">
  <h2 style="font-size:28px; color:#8B5E3C; margin-bottom:25px;">🔔 Notifications</h2>

  @if($notifications->count() > 0)
  <ul class="notification-list">
   @foreach($notifications as $note)
    <a href="{{ $note->data['url'] ?? '#' }}" class="notification-link">
      <li class="notification-item {{ $note->read_at ? '' : 'unread' }}">
        
        {{-- IMAGE OR ICON --}}
        @if(($note->data['type'] ?? '') === 'product' && isset($note->data['image']))
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
    <p class="no-notifs">No notifications available.</p>
  @endif
</section>

<style>
/* ===== NOTIFICATIONS STYLES ENHANCED ===== */
body {
    background: #f4f4f7;
    font-family: 'Poppins', sans-serif;
}

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
  gap: 18px;
  background: #fff;
  border-radius: 18px;
  padding: 18px 22px;
  margin-bottom: 16px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  transition: 0.4s ease;
  border-left: 5px solid transparent;
}

.notification-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 30px rgba(0,0,0,0.15);
}

.notification-item.unread {
  border-left: 6px solid #C08A56;
  background: linear-gradient(120deg,#fff7f0,#fff2e6);
}

.notif-img img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 14px;
  border: 2px solid #f0e6dc;
  transition: 0.3s ease;
}

.notif-img img:hover {
  transform: scale(1.05);
}

.notif-icon {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg,#ff7a18,#ffb347);
  color: white;
  font-size: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.3s ease;
}

.notif-icon:hover {
  transform: scale(1.1) rotate(-5deg);
}

.notif-content h4 {
  font-size: 17px;
  margin-bottom: 6px;
  color: #8B5E3C;
  font-weight: 600;
}

.notif-content p {
  font-size: 15px;
  color: #555;
  margin-bottom: 4px;
}

.notif-content small {
  font-size: 13px;
  color: #999;
}

.no-notifs {
  font-size: 16px;
  color: #aaa;
  text-align: center;
  margin-top: 30px;
}

/* Scroll bar for notifications if many */
.notification-list {
  max-height: 500px;
  overflow-y: auto;
  padding-right: 5px;
}

.notification-list::-webkit-scrollbar {
  width: 8px;
}

.notification-list::-webkit-scrollbar-thumb {
  background: #c08a56;
  border-radius: 10px;
}

.notification-list::-webkit-scrollbar-track {
  background: #f0e6dc;
  border-radius: 10px;
}
</style>
@endsection
