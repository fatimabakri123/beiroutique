
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title','Admin Dashboard') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin-categories.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/admin.js') }}"></script>


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
    :root {
    --bg: #f0f4ff;
    --primary: #6366f1;
    --primary-light: #a78bfa;
    --secondary: #22d3ee;
    --sidebar-bg: #ffffff;
    --sidebar-text: #1e293b;
    --sidebar-hover: #f1f5f9;
    --card: #ffffff;
    --radius: 16px;
    --shadow: rgba(0,0,0,0.08);
}

/* ===== Base ===== */
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--sidebar-text);
}

/* ===== Sidebar ===== */
.admin-sidebar {
    width: 280px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: var(--sidebar-bg);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 24px 20px;
    box-shadow: 5px 0 20px var(--shadow);
    overflow-y: auto;
    border-radius: 0 20px 20px 0;
}

.admin-sidebar::-webkit-scrollbar {
    width: 6px;
}

.admin-sidebar::-webkit-scrollbar-thumb {
    background: #750fc8;
    border-radius: 10px;
}

.admin-sidebar .brand {
    display: flex;
    gap: 12px;
    align-items: center;
    margin-bottom: 30px;
}

.admin-sidebar .logo {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    font-weight: 700;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.admin-sidebar .brand-text {
    font-size: 20px;
    font-weight: 700;
}

.admin-sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.admin-sidebar nav .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: var(--radius);
    color: var(--sidebar-text);
    font-weight: 600;
    font-size: 16px;
    transition: 0.25s;
}

.admin-sidebar nav .nav-link i {
    width: 24px;
    font-size: 18px;
}

.admin-sidebar nav .nav-link:hover {
    background: var(--sidebar-hover);
    transform: translateX(4px);
}

.admin-sidebar nav .nav-link.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff;
    box-shadow: 0 8px 20px var(--shadow);
}

/* Footer info */
.admin-sidebar .mt-4 {
    margin-top: auto;
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.5;
}

/* ===== Main content ===== */
.admin-main {
    margin-left: 280px;
    padding: 28px;
    transition: 0.3s;
}

/* ===== Topbar ===== */
.topbar {
    background: #fff;
    border-radius: var(--radius);
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 8px 20px var(--shadow);
    margin-bottom: 20px;
}

.topbar .search-input input {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 4px 8px;
}

/* ===== Cards ===== */
.card {
    background: var(--card);
    border-radius: var(--radius);
    padding: 20px;
    box-shadow: 0 12px 25px var(--shadow);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-4px);
}

/* ===== Buttons ===== */
.btn {
    border-radius: 12px;
    font-weight: 600;
}

/* ===== Tables ===== */
.table {
    border-collapse: separate;
    border-spacing: 0 8px;
}

.table thead th {
    border: none;
    color: #64748b;
    font-size: 13px;
    text-transform: uppercase;
}

.table tbody tr {
    background: var(--card);
    box-shadow: 0 8px 20px var(--shadow);
    transition: 0.25s;
}

.table tbody tr:hover {
    transform: scale(1.01);
}

.table td {
    border: none;
    padding: 14px;
}

/* ===== Responsive ===== */
@media(max-width:991px) {
    .admin-sidebar { left: -300px; }
    .admin-sidebar.show { left: 0; }
    .admin-main { margin-left: 0; }
}
/* ===== products===== */
/* ===== Product Cards ===== */
.card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 30px rgba(0,0,0,0.1);
}

/* Product Image */
.card img {
    border-radius: 12px;
    max-width: 100%;
    height: auto;
    margin-bottom: 12px;
    transition: transform 0.3s;
}

.card img:hover {
    transform: scale(1.05);
}

/* Product Details */
.card h3 {
    font-size: 1.5rem;
    color: #1e293b;
    margin-bottom: 8px;
}

.card p {
    font-size: 0.95rem;
    color: #475569;
    margin: 4px 0;
}

.card strong {
    color: #111827;
}

/* ===== Tables ===== */
.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.table thead th {
    background: #f0f4ff;
    color: #475569;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    padding: 10px 12px;
    border-radius: 12px 12px 0 0;
}

.table tbody tr {
    background: #ffffff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: transform 0.25s, box-shadow 0.25s;
    border-radius: 12px;
}

.table tbody tr:hover {
    transform: scale(1.01);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
}

.table td {
    padding: 10px 12px;
    vertical-align: middle;
    color: #334155;
}

.table td button,
.table td a.btn {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 12px;
    transition: all 0.3s;
}

.table td button:hover,
.table td a.btn:hover {
    transform: scale(1.05);
}

/* ===== Buttons ===== */
.btn-outline-primary {
    color: #6366f1;
    border-color: #6366f1;
}

.btn-outline-primary:hover {
    background: #6366f1;
    color: #fff;
    border-color: #6366f1;
}

.btn-outline-secondary {
    color: #475569;
    border-color: #475569;
}

.btn-outline-secondary:hover {
    background: #475569;
    color: #fff;
    border-color: #475569;
}

.btn-success {
    background: linear-gradient(135deg, #16a34a, #4ade80);
    border: none;
    color: #fff;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #f87171);
    border: none;
    color: #fff;
}

/* ===== Pending Products Header ===== */
h5 {
    color: #1e293b;
    margin-bottom: 12px;
    font-weight: 600;
}

/* ===== Filters ===== */
form select.form-select {
    border-radius: 12px;
    padding: 6px 10px;
    font-size: 0.85rem;
    border: 1px solid #e2e8f0;
}

form button {
    border-radius: 12px;
}

/* ===== Pagination Links ===== */
.pagination {
    display: flex;
    gap: 6px;
    margin-top: 12px;
}

.pagination li a {
    padding: 6px 10px;
    border-radius: 12px;
    color: #6366f1;
    border: 1px solid #6366f1;
    transition: 0.3s;
}

.pagination li a:hover,
.pagination li.active span {
    background: #6366f1;
    color: #fff;
    border-color: #6366f1;
}

/* ===== Responsive ===== */
@media(max-width: 768px){
    .table thead {
        display: none;
    }
    .table tbody tr {
        display: block;
        margin-bottom: 16px;
    }
    .table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 6px 10px;
    }
}

/* ===== products===== */
/* ===== categories===== */


    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin Sidebar">
       
        </div>

        <nav class="mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> <span class="label">Dashboard</span>
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

   <a href="{{ route('admin.subcategories') }}"
   class="nav-link {{ request()->is('admin/subcategories*') ? 'active' : '' }}">

        <i class="fa fa-layer-group"></i> <span class="label">Subcategories</span>
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
          <a href="{{ route('logout') }}" class="nav-link"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fa fa-right-from-bracket"></i> <span class="label">Logout</span>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

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

                
                
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- Notifications --}}
                
            

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
