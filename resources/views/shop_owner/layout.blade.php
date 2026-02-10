<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Shop Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
/* ===============================
   GLOBAL THEME VARIABLES
================================ */
:root {
  --purple-dark: #5b2a86;
  --purple-soft: #1f7bb8eb;
  --blue-soft: #8f3f9beb;

  --bg-light: #fdfcff;
  --white: #ffffff;

  --text-dark: #1e1b4b;
  --text-muted: #6b7280;

  --border-soft: rgba(226, 232, 240, 0.8);
  --shadow-soft: 0 18px 40px rgba(91, 42, 134, 0.18);
}

/* ===============================
   RESET
================================ */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background: var(--bg-light);
  color: var(--text-dark);
}

/* ===== SIDEBAR (MATCH CUSTOMER) ===== */
.sidebar {
  width: 300px; /* 👈 BIGGER like customer */
  background: linear-gradient(
    160deg,
    var(--blue-soft),
    var(--purple-soft),
    var(--purple-dark)
  );
  color: var(--white);
  padding: 34px 26px; /* more breathing room */
  box-shadow: var(--shadow-soft);

  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  z-index: 1000;

  transition: all 0.35s ease;
}

/* hide toggle */
.sidebar.hidden {
  left: -300px;
}


/* title */
.sidebar h2 {
  text-align: center;
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 35px;
  letter-spacing: 0.5px;
  color: #fff;
}

/* links */
.sidebar a {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 14px 20px; /* bigger click area */
  margin-bottom: 20px;
  border-radius: 16px;
  text-decoration: none;
  color: var(--white);
  font-size: 21px; /* 👈 same presence */
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(6px);
  transition: all 0.35s ease;
}


.sidebar a i {
  font-size: 16px;
}

/* hover magic */
.sidebar a:hover {
  background: rgba(255, 255, 255, 0.28);
  transform: translateX(8px) scale(1.05);
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}


/* ===== TOP BAR ===== */
.topbar {
  height: 60px;
  background: var(--white);
  display: flex;
  align-items: center;
  padding: 0 20px;
  margin-left: 300px; /* 👈 MATCH SIDEBAR */
  box-shadow: var(--shadow-soft);
  border-bottom: 1px solid var(--border-soft);
  transition: 0.35s ease;
}

.topbar.full {
  margin-left: 0;
}

/* ===== MAIN CONTENT ===== */
.main-content {
  margin-left: 300px; /* 👈 MATCH SIDEBAR */
  padding: 40px;
  min-height: 100vh;
  transition: 0.35s ease;
}

.main-content.full {
  margin-left: 0;
}

@media (max-width: 768px) {
  .sidebar {
    left: -260px;
  }

  .sidebar.show {
    left: 0;
  }

  .main-content,
  .topbar {
    margin-left: 0;
  }
}

/* ===============================
   CARDS
================================ */
.card {
  background: var(--white);
  border-radius: 14px;
  padding: 20px;
  box-shadow: var(--shadow-soft);
  border: 1px solid var(--border-soft);
  margin-bottom: 20px;
}

/* ===============================
   BUTTONS
================================ */
.btn {
  background: linear-gradient(
    135deg,
    var(--purple-soft),
    var(--blue-soft)
  );
  color: #fff;
  padding: 10px 18px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  transition: 0.3s ease;
}

.btn:hover {
  background: linear-gradient(
    135deg,
    var(--purple-dark),
    var(--purple-soft)
  );
  transform: translateY(-1px);
}

/* ===============================
   INPUTS
================================ */
input,
select,
textarea {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid var(--border-soft);
  outline: none;
  font-size: 14px;
}

input:focus,
select:focus,
textarea:focus {
  border-color: var(--purple-soft);
  box-shadow: 0 0 0 3px rgba(31, 123, 184, 0.2);
}

/* ===============================
   TEXT UTILITIES
================================ */
.text-muted {
  color: var(--text-muted);
}

.text-primary {
  color: var(--purple-dark);
}

/* ===============================
   RESPONSIVE
================================ */
@media (max-width: 768px) {
  .sidebar {
    left: -240px;
  }

  .sidebar.show {
    left: 0;
  }

  .main-content,
  .topbar {
    margin-left: 0;
  }
}   

</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h2> My Shop</h2>

    <a href="{{ route('shop.dashboard') }}">
        <i class="fa fa-home"></i> Dashboard
    </a>

    <a href="{{ route('shop_owner.statistics') }}">
        <i class="fa fa-chart-line"></i> Statistics
    </a>

    <a href="{{route('shopowner.notifications')}}" class="relative">
    <i class="fa fa-bell"></i>Notifications

</a>

   <a href="{{ route('shop.profile.edit') }}">
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

@yield('scripts')

</body>
</html>