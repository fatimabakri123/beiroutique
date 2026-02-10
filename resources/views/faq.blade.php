<form id="faqForm">
    <input type="text" id="question" placeholder="Ask your question..." required />
    <button type="submit">Ask</button>
</form>

<div id="answer"></div>

<script>
document.getElementById('faqForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const question = document.getElementById('question').value;

   const res = await fetch('/faq/ask', { // <-- new POST route
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ question })
});

    const data = await res.json();
    document.getElementById('answer').innerText = data.answer || 'No answer yet.';
});
</script>
