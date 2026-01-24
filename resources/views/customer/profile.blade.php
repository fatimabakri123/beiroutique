@extends('layouts.customer')

@section('content')

<style>
/* WRAPPER */
.profile-wrapper {
    max-width: 1100px;
    margin: 30px auto;
    padding: 20px;
    font-family: "Poppins", sans-serif;
}

/* HEADER CARD */
.profile-header {
    display: flex;
    align-items: center;
    gap: 25px;
    background: #fff;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 8px 26px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

/* AVATAR STYLE */
.avatar-box {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: #f7ede3;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 55px;
    color: #C08A56;
    position: relative;
    overflow: hidden;
}

/* if image exists */
.avatar-box img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
}

/* upload button small */
.upload-btn {
    position: absolute;
    bottom: -4px;
    right: -4px;
    width: 35px;
    height: 35px;
    background: #C08A56;
    border-radius: 50%;
    color: white;
    font-size: 22px;
    text-align: center;
    line-height: 33px;
    cursor: pointer;
}
.upload-btn input {
    display: none;
}

/* MAIN GRID */
.profile-container {
    display: grid;
    grid-template-columns: 33% 33% 33%;
    gap: 20px;
}

/* BOXES */
.profile-section {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.04);
}

.profile-section h3 {
    color: #7d4008ff;
    font-size: 18px;
    margin-bottom: 15px;
}

/* INPUTS */
.profile-section input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 12px;
    font-size: 14px;
}

/* BUTTON */
.profile-section button {
    width: 100%;
    background: #874405da;
    color: #fff;
    padding: 11px;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    transition: 0.3s;
}
.profile-section button:hover {
    background: #a07046;
}

/* ORDERS */
.orders-box {
    background: #f3eeeaff;
    padding: 15px;
    border-radius: 12px;
    border: 1px solid #eee;
}

/* MOBILE */
@media(max-width: 900px) {
    .profile-container {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-wrapper">

    {{-- HEADER --}}
    <div class="profile-header">

        <div class="avatar-box">
            @php
                $profilePath = 'uploads/profile/user_' . auth()->id() . '.jpg';
            @endphp

            @if(auth()->user()->profile_image) 
    <img id="profilePreview" src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
         alt="{{ auth()->user()->name }}">
@else

              
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            @endif

            <label class="upload-btn">
                +
                <input type="file" id="imageInput" name="image" accept="image/*">
            </label>
        </div>

        <div>
            <h2 style="margin: 0; color:#3e2a1f;">{{ auth()->user()->name }}</h2>
            <p style="margin: 5px 0; color:#777;">{{ auth()->user()->email }}</p>
        </div>

    </div>

    {{-- MAIN GRID --}}
    <div class="profile-container">

        {{-- EDIT PROFILE --}}
        <div class="profile-section">
            <h3>Edit Profile</h3>

            <form action="{{ route('customer.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label>Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" required>

                <label>Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" required>

                <label>Phone</label>
                <input type="text" name="phone_number" value="{{ auth()->user()->customer->phone_number ?? '' }}">

                <label>Address</label>
                <input type="text" name="address" value="{{ auth()->user()->customer->address ?? '' }}">

                <button type="submit">Save Changes</button>
            </form>
        </div>

        {{-- CHANGE PASSWORD --}}
        <div class="profile-section">
            <h3>Change Password</h3>

            <form action="{{ route('customer.updatePassword') }}" method="POST">
                @csrf

                <label>Current Password</label>
                <input type="password" name="current_password" required>

                <label>New Password</label>
                <input type="password" name="new_password" required>

                <label>Confirm Password</label>
                <input type="password" name="new_password_confirmation" required>

                <button type="submit">Update Password</button>
            </form>
        </div>

        {{-- ORDER SUMMARY --}}
        <div class="profile-section">
            <h3>Your Orders</h3>

            <div class="orders-box">
                <p><b>Total Orders:</b> {{ $ordersCount ?? 0 }}</p>
                <p><b>Delivered:</b> {{ $deliveredCount ?? 0 }}</p>
                <p><b>Pending:</b> {{ $pendingCount ?? 0 }}</p>

                <a href="{{ route('customer.orders') }}" style="color:#C08A56;font-weight:600;">View All Orders →</a>
            </div>
        </div>

    </div>

</div>

@endsection
