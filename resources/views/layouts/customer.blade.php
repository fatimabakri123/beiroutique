<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard | Beiroutique</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* ===== ROOT COLORS ===== */
 :root {
   --purple-dark: #5b2a86;
      --purple-soft: #1f7bb8eb;
      --blue-soft: #8f3f9beb;

  --bg-light: #fdfcff;
  --white: #ffffff;

  --text-dark: #1e1b4b;
  --text-muted: #6b7280;

  --border-soft: rgba(226,232,240,0.8);
  --shadow-soft: 0 18px 40px rgba(91, 42, 134, 0.18);
}


    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: var(--bg-light);
    }

    .dashboard-container {
      display: flex;
      min-height: 100vh;
    }

    /* ===== SIDEBAR ===== */
   .sidebar {
  width: 260px;
  background: linear-gradient(
    160deg,
    var(--blue-soft),
    var(--purple-soft),
    var(--purple-dark)
  );
  color: var(--white);
  padding: 30px 22px;
  box-shadow: var(--shadow-soft);

  position: fixed;   
  top: 0;            
  left: 0;          
  height: 100vh;   
  z-index: 1000;    
}
.main-content {
  flex: 1;
  padding: 40px;
  color: var(--text-dark);

  margin-left: 260px; 
}


    .sidebar h2 {
      text-align: center;
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 35px;
      letter-spacing: 0.5px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar ul li {
      margin-bottom: 18px;
    }

    .sidebar ul li a {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 16px;
      border-radius: 14px;
      text-decoration: none;
      color: var(--white);
      font-size: 20px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(6px);
      transition: all 0.35s ease;
    }

    .sidebar ul li a i {
      font-size: 16px;
    }

    .sidebar ul li a:hover {
      background: rgba(255, 255, 255, 0.28);
      transform: translateX(8px) scale(1.05);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* ===== LOGOUT ===== */
    .logout-btn {
      width: 100%;
      margin-top: 30px;
      padding: 12px;
      border-radius: 16px;
      border: none;
      background: linear-gradient(
        135deg,
        #ffffff,
        #f3e8ff
      );
      color: var(--purple-dark);
      font-weight: 700;
      cursor: pointer;
      transition: all 0.35s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .logout-btn:hover {
      background: linear-gradient(
        135deg,
        var(--purple-soft),
        var(--blue-soft)
      );
      color: var(--white);
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }

    /* ===== MAIN CONTENT ===== */
    .main-content {
      flex: 1;
      padding: 40px;
      color: var(--text-dark);
    }
    
  </style>
</head>

<body>
<div class="dashboard-container">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <h2>My Account</h2>
    <ul>
      <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{ route('customer.home') }}"><i class="fa fa-home"></i> Dashboard</a></li>
      <li><a href="{{ route('customer.profile') }}"><i class="fa fa-user"></i> Profile</a></li>
      <li><a href="{{ route('customer.orders') }}"><i class="fa fa-box"></i> Orders</a></li>
      <li><a href="{{ route('customer.cart') }}"><i class="fa fa-shopping-cart"></i> Cart</a></li>
      <li><a href="{{ route('customer.wishlist') }}"><i class="fa fa-heart"></i> Wishlist</a></li>
      <li><a href="{{ route('customer.reviews') }}"><i class="fa fa-star"></i> Reviews</a></li>
      <li><a href="{{ route('customer.notifications') }}" class="sidebar-link notif-btn">
    <i class="fa fa-bell"></i>
    <span>Notifications</span>

    @if(isset($unreadCount) && $unreadCount > 0)
        <span class="notif-dot"></span>
    @endif
</a>
</li>


      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">
          <i class="fa fa-sign-out"></i> Logout
        </button>
      </form>

      
    </ul>
  </aside>

  <!-- ===== MAIN ===== -->
  <main class="main-content">
    @yield('content')
  </main>

</div>
</body>
</html>
