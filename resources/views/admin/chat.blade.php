@extends('admin.layout')

@section('content')
<h2>Conversations</h2>

@if($conversations->count() > 0)
    <ul>
        @foreach($conversations as $conversation)
            <li>
                Conversation ID: {{ $conversation->id }} - 
                Created by: {{ $conversation->creator->name ?? 'Unknown' }}
                <a href="{{ route('chat.show', $conversation->id) }}">View Messages</a>
            </li>
        @endforeach
    </ul>
@else
    <p>No conversations found.</p>
@endif
@endsection
