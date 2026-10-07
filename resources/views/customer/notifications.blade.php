@extends('layouts.customer')

@section('content')
<section id="notifications" class="content-section active notif-page">

  <!-- Back Button -->
  <div class="back-btn-wrapper">
   
  </div>

  <div class="notif-header">
    <h2 class="notif-title">🔔 Notifications</h2>
</div>


  @if($notifications->count() > 0)
    <ul class="notification-list">
      @foreach($notifications as $note)
        <a href="{{ $note->data['url'] ?? '#' }}" class="notification-link">
          <li class="notification-item {{ $note->read_at ? '' : 'unread' }}">

           <div class="notif-icon-wrapper">
    @php
        $type = $note->data['type'] ?? '';
    @endphp

    @if($type === 'product')
        @php
            $images = collect($note->data['images'] ?? []);
            if ($images->isEmpty() && isset($note->data['image'])) {
                $images = collect([$note->data['image']]);
            }
        @endphp
        <div class="notif-slider">
            @foreach($images as $img)
                @php
                    if (is_array($img)) $img = $img[0] ?? null;
                @endphp
                @if($img)
                    <img src="{{ Str::startsWith($img, 'storage/') ? asset($img) : asset('storage/' . $img) }}"
                        class="notif-slide" alt="Product">
                @endif
            @endforeach
            @if($images->count() > 1)
                <button class="notif-arrow prev">❮</button>
                <button class="notif-arrow next">❯</button>
            @endif
        </div>

    @elseif($type === 'sale')
        <div class="notif-icon" style="background: linear-gradient(135deg,#ff4d4d,#ff9900);">🔥</div>

    @elseif($type === 'order_status_changed')
        <div class="notif-icon" style="background: linear-gradient(135deg,#5b2a86,#8f3f9b);">🚚</div>

    @elseif($type === 'loyalty')
        <div class="notif-icon" style="background: linear-gradient(135deg,#ffd700,#ffa500);">🎉</div>

    @else
        <div class="notif-icon" style="background: #ccc;">❔</div>
    @endif
</div>
{{-- IMAGE OR ICON --}}



            {{-- CONTENT --}}
            <div class="notif-content">
              <h4>{{ $note->data['title'] ?? 'No Title' }}</h4>
              <p>{{ $note->data['message'] ?? 'No Message' }}</p>
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
/* ===== PAGE CARD ===== */
.notif-page {
  background: linear-gradient(135deg, #fdfcff, #f6f0ff);
  padding: 10px 40px 30px; 
  border-radius: 24px;
  box-shadow: inset 0 0 0 1px rgba(124,77,255,0.08);
   height: 100vh;
  display: flex;
  flex-direction: column; 
   overflow: hidden; 
}


/* ===== BACK BUTTON ===== */
.back-btn-wrapper {
  margin-bottom: 25px;
}


.back-btn {
  display: inline-flex;
  align-items: center;

  padding: 10px 18px;
  background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
  color: #fff;
  font-weight: 600;
  font-size:20px;
  border-radius: 12px;
  text-decoration: none;
  box-shadow: 0 8px 25px rgba(124,77,255,0.25);
  transition: all 0.3s ease;
}

.back-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(96,165,250,0.35);
  color: #fff;
}
/* ===== TITLE ===== */
.notif-title {
  text-align: center;
  font-size: 28px;
  
  color: var(--purple-dark, #5b2a86);
  font-weight: 600;
}

/* ===== LIST ===== */
.notification-list {
  list-style: none;
  padding: 0;
  margin: 0 auto;
  width: 95%;
  max-width: 1100px;
    flex: 1;           
  overflow-y: auto;
}


/* Scrollbar */
.notification-list::-webkit-scrollbar {
  width: 8px;
}
.notification-list::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg,#8f3f9beb,#1f7bb8eb,#5b2a86);
  border-radius: 10px;
}
.notification-list::-webkit-scrollbar-track {
  background: #f4f4f7;
}

/* ===== ITEM ===== */
.notification-link {
  text-decoration: none;
  color: inherit;
}

.notification-item {
  display: flex;
  align-items: center;
  gap: 18px;

  border-radius: 18px;
  padding: 18px 22px;
  margin-bottom: 16px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  transition: 0.4s ease;
  border-left: 5px solid transparent;
  color: #fff;
}

.notification-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 30px rgba(0,0,0,0.15);
}

.notification-item.unread {
  border-left: 6px solid #4f8cff;
 background: linear-gradient(135deg, #a080bc, #5b93c7); 
}

/* ===== IMAGE / ICON ===== */
.notif-img img {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 14px;
  border: 2px solid #fff;
}

.notif-icon {
  width: 70px;
  height: 70px;
  background: linear-gradient(135deg,#8f3f9beb,#1f7bb8eb,#5b2a86);
  color: white;
  font-size: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ===== CONTENT ===== */
.notif-content { flex: 1; }

.notif-content h4 {
  font-size: 20px;
  margin-bottom: 6px;
  color: #fff;
  font-weight: 600;
}

.notif-content p {
  font-size: 18px;
  color: #faf5ff;
  margin-bottom: 4px;
  font-weight: 500;
}

.notif-content small {
  font-size: 16px;
  color: #e9d7f5;
}

/* ===== EMPTY ===== */
.no-notifs {
  font-size: 16px;
  color: #aaa;
  text-align: center;
  margin-top: 30px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px) {
  .notification-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }

  .notif-img img, .notif-icon {
    width: 60px;
    height: 60px;
    font-size: 24px;
  }
}

/* ===== NOTIFICATION IMAGE SLIDER ===== */
.notif-slider {
  position: relative;
  width: 70px;
  height: 70px;
}

.notif-slide {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 14px;
  border: 2px solid #fff;
  display: none;
}


.notif-slide:first-child {
  display: block;
}

.notif-slide.active {
  display: block;
}

/* arrows */
.notif-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 22px;
  height: 22px;
  border-radius: 50%;
  border: none;
  background: rgba(255,255,255,0.9);
  font-size: 12px;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0,0,0,0.25);
}

.notif-arrow.prev { left: -8px; }
.notif-arrow.next { right: -8px; }

.notif-arrow:hover {
  transform: translateY(-50%) scale(1.1);
}

.notif-header {
  flex-shrink: 0;
  position: sticky;
  top: 0;
  background: linear-gradient(135deg, #fdfcff, #f6f0ff);
  padding: 10px 0;
  z-index: 100;
}

.notification-list {
  list-style: none;
  padding: 0;
  margin: 0 auto;
  width: 95%;
  max-width: 1100px;

  flex: 1;              /* takes remaining space */
  overflow-y: auto;     /* ONLY this scrolls */
}

</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.notif-slider').forEach(slider => {
    const slides = slider.querySelectorAll('.notif-slide');
    if (!slides.length) return;

    let index = 0;
    slides[index].classList.add('active');

    const prev = slider.querySelector('.prev');
    const next = slider.querySelector('.next');

    function show(i) {
      slides.forEach(s => s.classList.remove('active'));
      slides[i].classList.add('active');
    }

    prev?.addEventListener('click', e => {
      e.preventDefault();
      e.stopPropagation();
      index = (index - 1 + slides.length) % slides.length;
      show(index);
    });

    next?.addEventListener('click', e => {
      e.preventDefault();
      e.stopPropagation();
      index = (index + slides.length) % slides.length;
      show(index);
    });
  });
});
</script>


@endsection