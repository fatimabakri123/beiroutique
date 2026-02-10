@extends('shop_owner.layout')

@section('title', 'Edit Profile')

@section('content')
<div class="edit-profile-wrapper">
<div class="edit-profile-container">
    <h2>Edit Shop Profile</h2>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('shop.profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Shop Name <span>*</span></label>
            <input type="text" name="shop_name" value="{{ $shop->shop_name }}" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4">{{ $shop->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="contact_phone" value="{{ $shop->contact_phone }}">
        </div>

        <div class="form-group">
            <label>Email <span>*</span></label>
            <input type="email" name="contact_email" value="{{ $shop->contact_email }}" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" value="{{ $shop->address }}">
        </div>

        <div class="form-group">
            <label>Logo</label>
            @if($shop->logo_url)
                <div class="logo-preview">
                    <img src="{{ asset('storage/'.$shop->logo_url) }}" alt="Shop Logo">
                </div>
            @endif
            <input type="file" name="logo">
        </div>

        <button type="submit" class="btn-save">Save Changes</button>
    </form>
</div>
</div>
@endsection

@section('scripts')
<style>
/* Container */
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

/* Container */
.edit-profile-container {
    max-width: 750px;
    margin: 40px auto;
    background: var(--bg-light);
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: var(--shadow-soft);
    font-family: 'Poppins', sans-serif;
}

/* Heading */
.edit-profile-container h2 {
    color: var(--purple-dark);
    margin-bottom: 25px;
    text-align: center;
}

/* Alerts */
.alert {
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 500;
}

.alert.success {
    background: rgba(31, 123, 184, 0.15);
    color: var(--purple-soft);
}

.alert.error {
    background: rgba(143, 63, 155, 0.15);
    color: var(--purple-dark);
}

/* Form Groups */
.form-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 6px;
    color: var(--text-dark);
}

.form-group label span {
    color: #e11d48;
}

/* Inputs */
.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="file"],
.form-group textarea {
    padding: 12px 15px;
    border: 1px solid var(--border-soft);
    border-radius: 8px;
    font-size: 15px;
    color: var(--text-dark);
    outline: none;
    transition: 0.25s ease;
    background: var(--white);
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--purple-soft);
    box-shadow: 0 0 0 3px rgba(31, 123, 184, 0.15);
}

/* Logo Preview */
.logo-preview img {
    height: 80px;
    border-radius: 10px;
    margin-bottom: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

/* Save Button */
.btn-save {
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: #fff;
    padding: 12px 32px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px rgba(91, 42, 134, 0.35);
}

/* Center content in screen */


/* Container: professional, fixed, medium width */
.edit-profile-container {
    width: 850px;             
    max-width: 95%;           
    padding: 40px 50px;       
    border-radius: 14px;
    box-shadow: var(--shadow-soft);
    font-size: 1.125rem;       /* slightly bigger than before */
    background: var(--bg-light);
    overflow: auto;
    max-height: 95%;          
}

/* Heading */
.edit-profile-container h2 {
    font-size: 2.3rem;        /* slightly bigger */
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;
    color: var(--purple-dark);
}

/* Alerts */
.alert {
    padding: 14px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: 600;
    font-size: 1.1rem;        /* slightly bigger */
}

/* Form Groups */
.form-group {
    margin-bottom: 22px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 6px;
    font-size: 1.15rem;       /* slightly bigger */
    color: var(--text-dark);
}

.form-group input,
.form-group textarea,
.form-group input[type="file"] {
    padding: 12px 15px;
    border-radius: 8px;
    font-size: 1.15rem;       /* slightly bigger */
}

/* Logo Preview */
.logo-preview img {
    height: 90px;
    border-radius: 10px;
    margin-bottom: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
}

/* Save Button */
.btn-save {
    padding: 14px 36px;
    font-size: 1.25rem;       /* slightly bigger */
    border-radius: 10px;
    font-weight: 600;
}


.edit-profile-container {
    max-width: 850px;
    width: 100%;
    margin: 40px auto;   /* THIS centers it properly */
    padding: 40px 50px;
    border-radius: 14px;
    box-shadow: var(--shadow-soft);
    background: var(--bg-light);
}

.edit-profile-wrapper {
    display: flex;
    justify-content: center; /* horizontal center */
    align-items: center;     /* vertical center */
    min-height: 100vh;       /* full screen height */
    padding: 20px;           /* small padding for small screens */
    box-sizing: border-box;
}

/* Keep your container size fixed */
.edit-profile-container {
    width: 850px;
    max-width: 95%;
    padding: 40px 50px;
    border-radius: 14px;
    box-shadow: var(--shadow-soft);
    background: var(--bg-light);
    overflow: auto;
}

.edit-profile-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;          /* fill viewport */
    padding: 20px;
    box-sizing: border-box;
}

.edit-profile-container {
    width: 850px;
    max-width: 100%;         /* fit small screens */
    max-height: 90vh;        /* do not exceed viewport height */
    overflow-y: auto;        /* scroll only inside container if needed */
    padding: 30px 40px;
    border-radius: 14px;
    box-shadow: var(--shadow-soft);
    background: var(--bg-light);
}

</style>
@endsection