<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="max-width:600px; margin:30px auto; font-family:sans-serif;">
    <h3>Chat with {{ $otherUser->name }}</h3>

<div id="chat-box" style="height:300px; overflow-y:auto; border:1px solid #ccc; padding:10px; margin-bottom:10px;">
    @foreach($chat->messages as $message)
        <div style="margin:5px 0;">
            <b>{{ $message->sender->name }}:</b> {{ $message->message }}
        </div>
    @endforeach
</div>


    <form id="chatForm">
        @csrf
        <input type="hidden" name="conversation_id" value="{{ $chat->id }}">
        <input type="text" name="message" placeholder="Type message..." required style="width:80%; padding:5px;">
        <button type="submit" style="padding:5px 10px;">Send</button>
    </form>
</div>

<!-- Pusher & Laravel Echo -->
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

<script>
    // إعداد Pusher و Echo
    Pusher.logToConsole = true;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env("PUSHER_APP_KEY") }}',
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        forceTLS: true
    });

    // إرسال الرسالة
    document.getElementById('chatForm').addEventListener('submit', function(e){
        e.preventDefault();

        fetch("{{ route('messages.send') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: new FormData(this)
        }).then(res => this.reset());
    });

    // استقبال الرسائل بشكل مباشر
    Echo.private('chat.{{ $chat->id }}')
        .listen('MessageSent', (e) => {
            let box = document.getElementById('chat-box');
            box.innerHTML += `
                <div style="margin:6px 0;">
                    <b>${e.message.sender_name}:</b> ${e.message.message}
                </div>
            `;
            box.scrollTop = box.scrollHeight; 
        });
</script>

</body>
</html>

