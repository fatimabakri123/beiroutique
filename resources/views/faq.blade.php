<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AI Assistant</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.chat-container {
    width: 100%;
    max-width: 500px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chat-messages {
    padding: 15px;
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.message {
    padding: 10px 14px;
    border-radius: 12px;
    max-width: 80%;
    font-size: 14px;
}

.user {
    background: #5a1f07a7;
    color: white;
    align-self: flex-end;
}

.ai {
    background: #eee;
    color: #000;
    align-self: flex-start;
}

.ai img {
    margin-top: 8px;
    max-width: 200px;
    border-radius: 12px;
}

.chat-input {
    display: flex;
    gap: 10px;
    padding: 12px;
    border-top: 1px solid #ddd;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border-radius: 20px;
    border: 1px solid #ccc;
    outline: none;
}

.chat-input button {
    padding: 10px 18px;
    border-radius: 20px;
    border: none;
    background: #5a1f07a7;
    color: white;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="chat-container">
    <div class="chat-messages" id="chat"></div>

    <div class="chat-input">
        <input type="text" id="question" placeholder="Ask about a product...">
        <button onclick="send()">Send</button>
    </div>
</div>

<script>
function send() {
    const q = document.getElementById('question');
    const text = q.value.trim();
    if (!text) return;

    addUser(text);
    q.value = '';

    fetch('/ask-ai', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ question: text })
    })
    .then(res => res.json())
    .then(data => addAI(data.answer, data.image))
    .catch(() => addAI('Something went wrong.'));
}

function addUser(text) {
    const chat = document.getElementById('chat');
    const div = document.createElement('div');
    div.className = 'message user';
    div.innerText = text;
    chat.appendChild(div);
    chat.scrollTop = chat.scrollHeight;
}

function addAI(text, image = null) {
    const chat = document.getElementById('chat');
    const div = document.createElement('div');
    div.className = 'message ai';
    div.innerText = text;

    if (image) {
        const img = document.createElement('img');
        img.src = image;
        div.appendChild(img);
    }

    chat.appendChild(div);
    chat.scrollTop = chat.scrollHeight;
}
</script>

</body>
</html>
