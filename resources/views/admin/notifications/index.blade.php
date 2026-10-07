@extends('admin.layout')
@section('title','Notifications')
@section('content')

<h3>Send Notification</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('notifications.send') }}" class="send-notif-form">
    @csrf
    <label>Target</label>
    <select name="target" id="targetSelect" required>
        <option value="users">Users</option>
        <option value="customers">Customers</option>
        <option value="shop_owners">Shop Owners</option>
    </select>

    <label>Title</label>
    <input type="text" name="title" required placeholder="Enter title">

    <label>Message</label>
    <textarea name="message" rows="4" required placeholder="Enter message"></textarea>

    <button type="submit">Send Notification</button>
</form>

<hr>


<style>
:root {
    --primary: #7b2fae;
    --primary-light: #a64dd1;
    --card: #fff;
    --bg: #f4f6fa;
    --text: #2c3e50;
    --muted: #7f8c8d;
    --shadow: 0 10px 25px rgba(124,77,255,0.08);
    --shadow-hover: 0 14px 35px rgba(124,77,255,0.18);
}

/* ===== SEND NOTIFICATION FORM ===== */
.send-notif-form {
    background: var(--card);
    padding: 22px;
    border-radius: 18px;
    box-shadow: var(--shadow);
    margin-bottom: 25px;
    transition: all 0.3s ease;
}
.send-notif-form:hover {
    box-shadow: var(--shadow-hover);
}

.send-notif-form label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--text);
}

.send-notif-form input,
.send-notif-form select,
.send-notif-form textarea {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid #ccc;
    margin-bottom: 15px;
    font-size: 14px;
    color: var(--text);
    transition: all 0.2s ease;
    background: #fafafa;
}
.send-notif-form input:focus,
.send-notif-form select:focus,
.send-notif-form textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 8px rgba(123,47,174,0.25);
}

.send-notif-form button {
    background: var(--primary);
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.send-notif-form button:hover {
    background: var(--primary-light);
    transform: translateY(-1px) scale(1.03);
}

/* ===== ALERT ===== */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 10px 15px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 14px;
}

/* ===== NOTIFICATIONS LIST (same as before) ===== */
#notif-box {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-height: 400px;
    overflow-y: auto;
    padding-right: 4px;
}
.notif-card {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    background: var(--card);
    padding: 16px 20px;
    border-radius: 18px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
}
.notif-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}
.notif-info {
    flex: 1;
    margin-right: 15px;
}
.notif-info strong { font-size: 16px; font-weight: 600; margin-bottom: 6px; display: block; }
.notif-info p { margin: 0; color: var(--muted); font-size: 14px; }
.notif-info small { display: block; margin-top: 4px; font-size: 12px; color: var(--primary); }

.notif-users strong { color: #36b9cc; }
.notif-customers strong { color: #1cc88a; }
.notif-shop_owners strong { color: #f6c23e; }
.notif-specific strong { color: #e74a3b; }

.notif-card button {
    background: #e74a3b;
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 6px 14px;
    font-size: 13px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s ease;
}
.notif-card button:hover {
    background: #c5302b;
    transform: translateY(-1px) scale(1.05);
}

#notif-box::-webkit-scrollbar { width: 6px; }
#notif-box::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
#notif-box::-webkit-scrollbar-track { background: #eaeaea; border-radius: 10px; }

@media(max-width:768px){
    .notif-card { flex-direction: column; align-items: flex-start; gap: 8px; }
    .notif-card button { align-self: flex-end; margin-top: 6px; }
}
</style>

@endsection