<h3>All Customer Chats</h3>

<ul>
@foreach($chats as $chat)
    @php
        $otherUserId = $chat->user_one_id === auth()->id() ? $chat->user_two_id : $chat->user_one_id;
    @endphp
    <li>
        <a href="{{ route('shop.chat.show', $chat->id) }}">Chat with User #{{ $otherUserId }}</a>
        ({{ $chat->messages->count() }} messages)
    </li>
@endforeach
</ul>
