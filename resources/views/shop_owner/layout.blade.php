<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Shop Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
       :root {
    --primary: #6C63FF;
    --bg: #F4F6FB;
    --sidebar-bg: #ffffff;
    --text: #2D2E32;
    --muted: #8B8E98;
    --hover: #EDEBFF;
    --shadow: 0 10px 30px rgba(0,0,0,0.06);
}

/* DARK MODE */
body.dark {
    --bg: #181A20;
    --sidebar-bg: #1F222A;
    --text: #ffffff;
    --hover: #2A2D36;
}

/* RESET */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: var(--bg);
    color: var(--text);
    transition: background 0.3s, color 0.3s;
}

/* ===== SIDEBAR ===== */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 240px;
    height: 100vh;
    background: var(--sidebar-bg);
    box-shadow: var(--shadow);
    padding-top: 25px;
    transition: 0.35s ease;
    z-index: 1000;
}

.sidebar.hidden {
    transform: translateX(-100%);
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
    color: var(--primary);
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 24px;
    color: var(--text);
    text-decoration: none;
    font-size: 15px;
    transition: 0.3s;
    border-left: 4px solid transparent;
}

.sidebar a:hover {
    background: var(--hover);
}

.sidebar a.active {
    background: var(--hover);
    border-left: 4px solid var(--primary);
    color: var(--primary);
}

.sidebar i {
    font-size: 16px;
}

/* ===== TOP BAR ===== */
.topbar {
    height: 60px;
    background: var(--sidebar-bg);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    margin-left: 240px;
    transition: 0.3s;
}

.topbar.full {
    margin-left: 0;
}

.toggle-btn {
    font-size: 22px;
    cursor: pointer;
}

/* DARK MODE BUTTON */
.dark-btn {
    cursor: pointer;
    font-size: 18px;
    color: var(--primary);
}

/* ===== MAIN CONTENT ===== */
.main-content {
    margin-left: 240px;
    padding: 30px;
    transition: 0.3s;
}

.main-content.full {
    margin-left: 0;
}

/* ===== MICRO ANIMATIONS ===== */
.sidebar a,
.toggle-btn,
.dark-btn {
    transition: transform 0.2s ease, background 0.2s ease;
}

.sidebar a:hover {
    transform: translateX(6px);
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar.show {
        transform: translateX(0);
    }
    .topbar {
        margin-left: 0;
    }
    .main-content {
        margin-left: 0;
    }
}

    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h2>🛒 My Shop</h2>

   <a href="{{ route('shop.dashboard') }}" class="{{ request()->routeIs('shop.dashboard') ? 'active' : '' }}">
    <i class="fa fa-home"></i> Dashboard
</a>

<a href="{{ route('shop_owner.statistics') }}" class="{{ request()->routeIs('shop_owner.statistics') ? 'active' : '' }}">
    <i class="fa fa-chart-line"></i> Statistics
</a>

<a href="{{ route('shop.profile.edit') }}" class="{{ request()->routeIs('shop.profile.edit') ? 'active' : '' }}">
    <i class="fa fa-pen"></i> Edit Profile
</a>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</div>

<!-- TOP BAR -->
<div class="topbar" id="topbar">
    <i class="fa fa-bars toggle-btn" onclick="toggleSidebar()"></i>
    <i class="fa fa-moon dark-btn" onclick="toggleDarkMode()"></i>
</div>


<!-- PAGE CONTENT -->
<div class="main-content" id="mainContent">
    @yield('content')
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('hidden');
        document.getElementById('mainContent').classList.toggle('full');
        document.getElementById('topbar').classList.toggle('full');
    }
</script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('mainContent').classList.toggle('full');
    document.getElementById('topbar').classList.toggle('full');
}

function toggleDarkMode() {
    document.body.classList.toggle('dark');
    localStorage.setItem('darkMode', document.body.classList.contains('dark'));
}

// KEEP DARK MODE
if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark');
}
</script>

@yield('scripts')

</body>
</html>
