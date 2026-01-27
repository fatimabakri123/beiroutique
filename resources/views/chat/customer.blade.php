<h3>Live Chat</h3>

<div id="chat-box" style="height:300px; overflow-y:scroll; border:1px solid #ccc; padding:10px;"></div>

<input type="text" id="message" placeholder="Type message..." style="width:70%;">
<button id="send">Send</button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// CSRF setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

let chatId = {{ $chat->id }};

// تحميل الرسائل
function loadMessages() {
    $.get('{{ url("/chat/fetch") }}/' + chatId, function(data) {
        $('#chat-box').html('');
        data.forEach(msg => {
            let sender = msg.sender_id === {{ auth()->id() }} ? 'You' : 'Owner';
            let align = msg.sender_id === {{ auth()->id() }} ? 'right' : 'left';
            $('#chat-box').append('<p style="text-align:' + align + ';"><strong>' + sender + ':</strong> ' + msg.message + '</p>');
        });
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });
}

// إرسال رسالة
$('#send').click(function () {
    let message = $('#message').val();
    if(message.trim() === '') return;

    $.post('{{ route("chat.send") }}', { chat_id: chatId, message: message })
    .done(function(data) {
        $('#message').val('');
        loadMessages();
    })
    .fail(function(xhr) {
        console.log(xhr.status);
        console.log(xhr.responseText);
        alert('Error sending message! Check console.');
    });
});

// تحديث الرسائل كل ثانيتين
setInterval(loadMessages, 2000);
loadMessages();
</script>
