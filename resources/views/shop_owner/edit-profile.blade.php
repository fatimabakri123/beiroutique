@extends('shop_owner.layout')

@section('title', 'Edit Profile')

@section('content')
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

@endsection

@section('scripts')
<style>
/* Container */
.edit-profile-container {
    max-width: 750px;
    margin: 40px auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    font-family: 'Poppins', sans-serif;
}

/* Headings */
.edit-profile-container h2 {
    color: #8B5E3C;
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
.alert.success { background: #d5fcda; color: #2d662d; }
.alert.error { background: #fcd5d5; color: #a94442; }

/* Form Groups */
.form-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}
.form-group label {
    font-weight: 500;
    margin-bottom: 6px;
    color: #3e2a1f;
}
.form-group label span { color: red; }

/* Inputs & Textarea */
.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="file"],
.form-group textarea {
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 15px;
    outline: none;
    transition: 0.2s;
}
.form-group input:focus,
.form-group textarea:focus {
    border-color: #8B5E3C;
    box-shadow: 0 0 5px rgba(139,94,60,0.3);
}

/* Logo Preview */
.logo-preview img {
    height: 80px;
    border-radius: 8px;
    margin-bottom: 10px;
}

/* Save Button */
.btn-save {
    display: inline-block;
    background: #8B5E3C;
    color: #fff;
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.3s;
}
.btn-save:hover {
    background: #C08A56;
}
</style>
@endsection