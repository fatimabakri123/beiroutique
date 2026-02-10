@extends('layouts.customer')

@section('content')

<style>
/* ===== PROFILE PAGE SAFE CSS (won't break layout) ===== */

.profile-page {
  width: 100%;
  min-height: 100%;
  background: #f5f6fb;
}

.profile-wrapper {
  width: 100%;
  padding: 20px;
}

/* ===== HEADER ===== */
.profile-header {
  display: flex;
  align-items: center;
  gap: 20px;
  background: #fff;
  padding: 20px;
  border-radius: 18px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  margin-bottom: 25px;
}

.avatar-box {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  background: linear-gradient(135deg, #e9d5ff, #dbeafe);
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 40px;
  color: #5b2d8b;
  position: relative;
  overflow: hidden;
}

.avatar-box img {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
}

.upload-btn {
  position: absolute;
  bottom: -5px;
  right: -5px;
  width: 34px;
  height: 34px;
  background: linear-gradient(135deg, #7c4dff, #4f8cff);
  border-radius: 50%;
  color: #fff;
  font-size: 18px;
  text-align: center;
  line-height: 34px;
  cursor: pointer;
}

.upload-btn input { display: none; }

/* ===== GRID ===== */
.profile-container {
  display: grid;
  grid-template-columns: 1.2fr 1fr 0.8fr;
  gap: 18px;
}

.profile-section {
  background: #fff;
  padding: 18px;
  border-radius: 16px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

.profile-section h3 {
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 10px;
  color: #5b2d8b;
}

/* ===== INPUTS ===== */
.profile-section label {
  font-size: 12px;
  font-weight: 600;
  color: #6b7280;
}

.profile-section input {
  width: 100%;
  padding: 8px 10px;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  margin: 4px 0 10px;
  font-size: 13px;
}

.profile-section button {
  width: 100%;
  background: linear-gradient(135deg, #7c4dff, #4f8cff);
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
}

.orders-box {
  background: linear-gradient(135deg, #f3e8ff, #eef2ff);
  padding: 12px;
  border-radius: 12px;
  font-size: 13px;
}

.orders-box a {
  display: inline-block;
  margin-top: 8px;
  color: #5b2d8b;
  font-weight: 700;
  text-decoration: none;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
  .profile-container {
    grid-template-columns: 1fr;
  }
  .profile-header {
    flex-direction: column;
    text-align: center;
  }
}
</style>

<div class="profile-page">
<div class="profile-wrapper">

  <!-- HEADER -->
  <div class="profile-header">
    <div class="avatar-box">
      @if(auth()->user()->profile_image)
        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}">
      @else
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      @endif
      <label class="upload-btn">+
        <input type="file">
      </label>
    </div>

    <div>
      <h2>{{ auth()->user()->name }}</h2>
      <p>{{ auth()->user()->email }}</p>
    </div>
  </div>

  <!-- GRID -->
  <div class="profile-container">

    <!-- EDIT PROFILE -->
    <div class="profile-section">
      <h3>Edit Profile</h3>
      <form method="POST" action="{{ route('customer.updateProfile') }}">
        @csrf
        <label>Name</label>
        <input type="text" name="name" value="{{ auth()->user()->name }}">

        <label>Email</label>
        <input type="email" name="email" value="{{ auth()->user()->email }}">

        <label>Phone</label>
        <input type="text" name="phone_number"
               value="{{ old('phone_number', auth()->user()->customer?->phone_number ?? '') }}">

        <label>Address</label>
        <input type="text" name="address"
               value="{{ old('address', auth()->user()->customer?->address ?? '') }}">

        <button>Save Changes</button>
      </form>
    </div>

    <!-- PASSWORD -->
    <div class="profile-section">
      <h3>Change Password</h3>
      <form method="POST" action="{{ route('customer.updatePassword') }}">
        @csrf
        <label>Current Password</label>
        <input type="password" name="current_password">

        <label>New Password</label>
        <input type="password" name="new_password">

        <label>Confirm Password</label>
        <input type="password" name="new_password_confirmation">

        <button>Update Password</button>
      </form>
    </div>

    <!-- ORDERS -->
    <div class="profile-section">
      <h3>Your Orders</h3>
      <div class="orders-box">
        <p><b>Total Orders:</b> {{ $ordersCount ?? 0 }}</p>
        <p><b>Delivered:</b> {{ $deliveredCount ?? 0 }}</p>
        <p><b>Pending:</b> {{ $pendingCount ?? 0 }}</p>
        <a href="{{ route('customer.orders') }}">View All Orders →</a>
      </div>
    </div>

  </div>
</div>
</div>

@endsection
