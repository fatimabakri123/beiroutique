@extends('layouts.customer')

@section('content')
<section id="dashboard-home" class="content-section active">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <h1>Welcome, {{ $user->name }} 👋</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fa fa-box"></i>
            <h3>Orders</h3>
            <p>{{ $ordersCount ?? 0 }} Active Orders</p>
        </div>

        <div class="stat-card">
            <i class="fa fa-heart"></i>
            <a href="{{ route('customer.wishlist') }}">
                <h3>Wishlist</h3>
            </a>
            <p>{{ $wishlistCount ?? 0 }} Items Saved</p>
        </div>

        <div class="stat-card">
            <i class="fa fa-bell"></i>
            <h3>Notifications</h3>
            <p>{{ $notifications->count() ?? 0 }} New Alerts</p>
        </div>
    </div>
<div class="ai-chat">
    <div class="chat-header">Ask Beirut Boutique ✨</div>

    <div id="chat-body"></div>

    <div class="chat-input">
        <input type="text" id="userText" placeholder="Ask for a gift..." 
            onkeydown="if(event.key==='Enter') sendMsg();" />
        <button type="button" onclick="sendMsg()">➤</button>
    </div>
</div>

<style>
.ai-chat {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 320px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 15px 40px rgba(0,0,0,.15);
  overflow: hidden;
  font-family: 'Poppins', sans-serif;
}

.chat-header {
  background: #111;
  color: #fff;
  padding: 14px;
  font-weight: 600;
}

#chat-body {
  height: 300px;
  padding: 10px;
  overflow-y: auto;
}

.chat-input {
  display: flex;
  border-top: 1px solid #eee;
}

.chat-input input {
  flex: 1;
  padding: 10px;
  border: none;
}

.chat-input button {
  background: #111;
  color: white;
  border: none;
  padding: 0 18px;
  cursor: pointer;
}

.product {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
}

.product img {
  width: 60px;
  border-radius: 8px;
}
</style>
<script>
    function sendMsg() {
  const input = document.getElementById('userText');
  const text = input.value.trim();
  if(!text) return;

  const chat = document.getElementById('chat-body');
  chat.innerHTML += `<p><b>You:</b> ${text}</p>`;
  chat.innerHTML += `<p><b>AI:</b> Searching...</p>`;

  fetch('{{ route("ai-chat") }}', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ question: text })
  })
  .then(res => res.json())
  .then(data => {
      chat.querySelector("p:last-child").remove(); // إزالة "Searching..."
      if(!Array.isArray(data) || data.length === 0){
          chat.innerHTML += `<p><b>AI:</b> No products found 😔</p>`;
          return;
      }

      data.forEach(p => {
          chat.innerHTML += `
            <div class="product">
                <img src="/storage/${p.image_url}">
                <div>
                    <strong>${p.product_name}</strong><br>
                    $${p.price}
                </div>
            </div>
          `;
      });
      chat.scrollTop = chat.scrollHeight;
  })
  .catch(err => {
      console.error(err);
      chat.innerHTML += `<p><b>AI:</b> Something went wrong 😔</p>`;
  });

  input.value = '';
}
</script>


</section>

@endsection
