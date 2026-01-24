<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard | Beiroutique</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="dashboard-container">

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>My Account</h2>
    <ul>
      <li><a href="{{ route('customer.home') }}"><i class="fa fa-home"></i> Dashboard</a></li>
      <li><a href="{{ route('customer.profile') }}"><i class="fa fa-user"></i> Profile</a></li>
      <li><a href="{{ route('customer.orders') }}"><i class="fa fa-box"></i> Orders</a></li>
      <li><a href="{{ route('customer.cart') }}"><i class="fa fa-shopping-cart"></i> Cart</a></li>
      <li><a href="{{ route('customer.wishlist') }}"><i class="fa fa-heart"></i> Wishlist</a></li>
      <li><a href="{{ route('customer.reviews') }}"><i class="fa fa-star"></i> Reviews</a></li>
      <li><a href="{{ route('customer.notifications') }}"><i class="fa fa-bell"></i> Notifications</a></li>
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="logout-btn">
            <i class="fa fa-sign-out"></i> Logout
          </button>
          
        </form>
      <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    @yield('content')
  </main>

</div>
</body>
</html>
