<div class="faq-ai-box">
    <h3>Ask Beiroutique AI 🤖</h3>
    <input type="text" id="faqInput" placeholder="Ask your question...">
    <button onclick="askAI()">Ask</button>
    <div id="faqAnswer" class="faq-answer"></div>
</div>
<script>
 async function askAI(){
    const q = document.getElementById('faqInput').value;

    const res = await fetch('/ai-faq',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
        },
        body:JSON.stringify({question:q})
    });

    const data = await res.text();
    document.getElementById('faqAnswer').innerText = data;
}

 