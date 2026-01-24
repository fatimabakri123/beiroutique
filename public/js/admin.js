// admin.js

// Send AJAX POST (requires csrf token meta tag in layout)
function adminPost(url, data = {}, onSuccess=null, onError=null){
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    fetch(url, { method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':token}, body: JSON.stringify(data) })
        .then(r => r.json()).then(res => { if(onSuccess) onSuccess(res); }).catch(e => { if(onError) onError(e); });
}

// Toggle status example (button should have data-url)
document.addEventListener('click', function(e){
    const el = e.target.closest('[data-admin-toggle]');
    if(!el) return;
    e.preventDefault();
    if(!confirm('Proceed?')) return;
    adminPost(el.dataset.adminToggle, {}, (res)=>{ location.reload(); }, (err)=>{ alert('Failed'); });
});
