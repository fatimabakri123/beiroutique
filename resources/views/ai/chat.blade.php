<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="max-width:600px; margin:auto;">

    <h3>AI Assistant</h3>

    {{-- Chat Box --}}
    <div id="chatBox" style="border:1px solid #ccc; padding:10px; min-height:200px; margin-bottom:10px;">
        <p><strong>AI:</strong> مرحبا! اسألني أي شي 😊</p>
    </div>

    {{-- Input --}}
    <form id="aiForm">
        @csrf
        <input type="text" id="question" name="question"
               placeholder="اكتب سؤالك..."
               style="width:80%;" required>

        <button type="submit">Send</button>
    </form>

</div>

{{-- JS --}}
<script>
document.getElementById('aiForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let questionInput = document.getElementById('question');
    let question = questionInput.value.trim();
    let chatBox = document.getElementById('chatBox');

    if (!question) return;

    // User message
    chatBox.innerHTML += `<p><strong>You:</strong> ${question}</p>`;
    questionInput.value = '';

    fetch("{{ route('ai.chat') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        },
        body: JSON.stringify({ question })
    })
    .then(async res => {
        if (!res.ok) {
            let text = await res.text();
            throw new Error(text);
        }
        return res.json();
    })
    .then(data => {
        chatBox.innerHTML += `<p><strong>AI:</strong> ${data.answer}</p>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    })
    .catch(err => {
        console.error(err);
        chatBox.innerHTML += `<p style="color:red;"><strong>AI:</strong> صار خطأ، جرّبي مرة تانية 😕</p>`;
    });
});
</script>

</body>
</html>


