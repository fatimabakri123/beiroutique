
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title','Admin Dashboard') — {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/admin.js') }}"></script>


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
     :root{
    --bg:#f4f6fb;
    --primary:#6366f1;
    --primary-dark:#4f46e5;
    --dark:#0f172a;
    --dark-soft:#1e293b;
    --muted:#94a3b8;
    --card:#ffffff;
    --radius:18px;
}

/* ================= Base ================= */
html,body{height:100%}
body{
    font-family:'Inter',system-ui,-apple-system,BlinkMacSystemFont;
    background:linear-gradient(180deg,#f6f8ff,#eef2ff);
    margin:0;
    color:#0f172a;
}

/* ================= Sidebar ================= */
.admin-sidebar{
    width:260px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:linear-gradient(180deg,#0f172a,#020617);
    padding:22px 18px;
    overflow:auto;
    box-shadow:20px 0 50px rgba(0,0,0,.25);
}

.admin-sidebar::-webkit-scrollbar{width:4px}
.admin-sidebar::-webkit-scrollbar-thumb{
    background:#475569;border-radius:10px;
}

.admin-sidebar .brand{
    display:flex;
    gap:12px;
    align-items:center;
    margin-bottom:30px;
}

.admin-sidebar .logo{
    width:46px;height:46px;
    border-radius:14px;
    background:linear-gradient(135deg,var(--primary),#22d3ee);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-weight:800;
    font-size:18px;
}

.admin-sidebar .brand-text{
    font-size:16px;
}

.admin-sidebar nav .nav-link{
    color:#cbd5f5;
    padding:12px 14px;
    border-radius:14px;
    margin-bottom:6px;
    display:flex;
    align-items:center;
    gap:12px;
    font-weight:500;
    transition:.25s;
}

.admin-sidebar nav .nav-link i{
    width:20px;
    font-size:15px;
}

.admin-sidebar nav .nav-link:hover{
    background:#1e293b;
    transform:translateX(4px);
    color:#fff;
}

.admin-sidebar nav .nav-link.active{
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    color:#fff;
    box-shadow:0 10px 25px rgba(99,102,241,.45);
}

/* ================= Main ================= */
.admin-main{
    margin-left:260px;
    padding:28px;
    transition:.3s;
}

/* ================= Topbar ================= */
.topbar{
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(10px);
    border-radius:var(--radius);
    padding:14px 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 20px 40px rgba(15,23,42,.08);
}

.topbar .search-input input{
    border-radius:14px;
    border:1px solid #e2e8f0;
}

/* ================= Cards ================= */
.card{
    background:var(--card);
    border:none;
    border-radius:var(--radius);
    box-shadow:0 25px 60px rgba(0,0,0,.08);
    transition:.3s;
}

.card:hover{
    transform:translateY(-6px);
}

/* ================= Stat Cards ================= */
.stat-card{
    border-radius:20px;
    padding:22px;
    display:flex;
    align-items:center;
    gap:18px;
    color:#fff;
    position:relative;
    overflow:hidden;
}

.stat-card::after{
    content:'';
    position:absolute;
    width:140px;height:140px;
    background:rgba(255,255,255,.15);
    border-radius:50%;
    right:-40px;top:-40px;
}

.stat-card i{
    font-size:34px;
}

.stat-card h3{
    margin:0;
    font-weight:800;
}

.stat-purple{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
.stat-blue{background:linear-gradient(135deg,#2563eb,#60a5fa)}
.stat-green{background:linear-gradient(135deg,#16a34a,#4ade80)}
.stat-orange{background:linear-gradient(135deg,#f97316,#fdba74)}

/* ================= Tables ================= */
.table{
    border-collapse:separate;
    border-spacing:0 10px;
}

.table thead th{
    border:none;
    color:#64748b;
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:.05em;
}

.table tbody tr{
    background:#fff;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
    transition:.25s;
}

.table tbody tr:hover{
    transform:scale(1.01);
}

.table td{
    border:none;
    padding:16px;
}

/* ================= Buttons ================= */
.btn{
    border-radius:12px;
    font-weight:600;
}

.btn-danger{
    background:linear-gradient(135deg,#ef4444,#dc2626);
    border:none;
}

/* ================= Sidebar Collapse ================= */
.sidebar-collapsed .admin-sidebar{width:78px}
.sidebar-collapsed .admin-main{margin-left:78px}
.sidebar-collapsed .label,
.sidebar-collapsed .brand-text{display:none}

/* ================= Mobile ================= */
@media(max-width:991px){
    .admin-sidebar{left:-300px}
    .admin-sidebar.show{left:0}
    .admin-main{margin-left:0}
}

    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin Sidebar">
        <div class="brand">
            <div class="logo text-white">AD</div>
            <div>
                <div class="brand-text text-white fw-bold">Admin Panel</div>
                <div class="small">Platform Control</div>
            </div>
        </div>

        <nav class="mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> <span class="label">Dashboard</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fa fa-user"></i> <span class="label">Users</span>
            </a>

            <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> <span class="label">Customers</span>
            </a>
        
            <a href="{{ route('admin.shopowners.index') }}" class="nav-link {{ request()->is('admin/shopowners*') ? 'active' : '' }}">
                <i class="fa fa-user-tie"></i> <span class="label">Shop Owners</span>
            </a>

            <a href="{{ route('admin.shops.index') }}" class="nav-link {{ request()->is('admin/shops*') ? 'active' : '' }}">
                <i class="fa fa-store"></i> <span class="label">Shops</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fa fa-box"></i> <span class="label">Products</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
    <i class="fa fa-tags"></i> <span class="label">Categories</span>
</a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fa fa-shopping-cart"></i> <span class="label">Orders</span>
            </a>

          

            <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->is('admin/notifications*') ? 'active' : '' }}">
                <i class="fa fa-bell"></i> <span class="label">Notifications</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="fa fa-gear"></i> <span class="label">Settings</span>
            </a>
        </nav>

        <div class="mt-4 small text-white-50">
            <div class="mb-2">Signed in as</div>
            <div class="fw-semibold text-white">{{ auth()->user()?->name ?? 'Admin' }}</div>
            <div class="small mt-2">Version 1.0</div>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="admin-main" id="adminMain">

        {{-- Topbar --}}
        <div class="topbar mb-3">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-lg-none" id="mobileSidebarToggle" title="Toggle sidebar">
                    <i class="fa fa-bars"></i>
                </button>

                <button class="btn btn-sm btn-outline-secondary d-none d-lg-inline" id="sidebarToggle" title="Toggle collapse">
                    <i class="fa fa-bars"></i>
                </button>

                <form class="d-flex align-items-center" onsubmit="event.preventDefault();">
                    <div class="input-group search-input">
                        <input type="search" id="adminSearch" class="form-control form-control-sm" placeholder="Search users, orders, products..." aria-label="Search">
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="performSearch()">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- Notifications --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-light position-relative" id="notifBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifCount" style="font-size:10px;display:none">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="width:320px" aria-labelledby="notifBtn" id="notifDropdown">
                        <li class="dropdown-header">Notifications</li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="text-center small text-muted">No notifications</li>
                    </ul>
                </div>

                {{-- Messages --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" id="msgBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="width:320px" aria-labelledby="msgBtn">
                        <a href="{{ route('chat.index') }}" class="dropdown-item text-center small text-primary fw-bold">Go to Chat</a>
                        <li class="dropdown-header">Messages</li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="text-center small text-muted">No messages</li>
                    </ul>
                </div>

                {{-- Admin menu --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                       
                        <span class="d-none d-md-inline">{{ auth()->user()?->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fa fa-gear me-2"></i> Settings</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa fa-user me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit"><i class="fa fa-right-from-bracket me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Page content slot --}}
        <div>
            @yield('content')
        </div>

        {{-- Footer (small) --}}
        <footer class="mt-4 text-center small text-muted">
            © {{ date('Y') }} {{ config('app.name') }} — Admin Panel
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js placeholder (add charts in specific pages) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>

    <script>
        // Sidebar toggle (collapse for large screens)
        const sidebarToggle = document.getElementById('sidebarToggle');
        const adminBody = document.documentElement;
        sidebarToggle?.addEventListener('click', () => {
            adminBody.classList.toggle('sidebar-collapsed');
        });

        // Mobile behavior: show / hide sidebar
        const mobileToggle = document.getElementById('mobileSidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        mobileToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

        // Simple search function (hook to backend as needed)
    function performSearch(){
    const q = document.getElementById('adminSearch').value.trim();
    if(!q) return;
    window.location = "{{ route('admin.search') }}" + "?q=" + encodeURIComponent(q);
}



        // Notifications demo: you can replace with AJAX to load real notifications
        function showNotificationList(items = []) {
            const dropdown = document.getElementById('notifDropdown');
            const count = document.getElementById('notifCount');

            dropdown.innerHTML = '<li class="dropdown-header">Notifications</li><li><hr class="dropdown-divider"></li>';

            if(!items.length){
                dropdown.innerHTML += '<li class="text-center small text-muted">No notifications</li>';
                count.style.display = 'none';
                return;
            }

            items.forEach(i => {
                const li = document.createElement('li');
                li.innerHTML = `<a class="dropdown-item" href="${i.url || '#'}">
                    <div class="d-flex align-items-start">
                        <div class="me-2"><i class="${i.icon || 'fa fa-bell'}"></i></div>
                        <div><div class="small fw-semibold">${i.title}</div><div class="small text-muted">${i.time}</div></div>
                    </div>
                </a>`;
                dropdown.appendChild(li);
            });

            count.innerText = items.length;
            count.style.display = 'inline-block';
        }

        // Demo: call with sample data (remove in production)
        // showNotificationList([
        //     { title: 'New order #1023', time: '2m ago', url: '/admin/orders/1023' },
        //     { title: 'Product pending approval', time: '1h ago', url: '/admin/products/pending' },
        // ]);
    </script>

    @stack('scripts')
</body>
</html>
