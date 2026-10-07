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

        <div class="form-row">
            <div class="form-group half">
                <label>Shop Name <span>*</span></label>
                <input type="text" name="shop_name" value="{{ $shop->shop_name }}" required>
            </div>

            <div class="form-group half">
                <label>Phone</label>
                <input type="text" name="contact_phone" value="{{ $shop->contact_phone }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group half">
                <label>Email <span>*</span></label>
                <input type="email" name="contact_email" value="{{ $shop->contact_email }}" required>
            </div>

            <div class="form-group half">
                <label>Address</label>
                <input type="text" name="address" value="{{ $shop->address }}">
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3">{{ $shop->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Logo</label>
            <div class="logo-section">
                @if($shop->logo_url)
                    <div class="logo-preview">
                        <img src="{{ asset('storage/'.$shop->logo_url) }}" alt="Shop Logo">
                    </div>
                @endif
                <input type="file" name="logo" id="logo" class="file-input">
                <label for="logo" class="file-label">Choose File</label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Changes</button>
        </div>
    </form>
</div>
</div>
@endsection

@section('scripts')
<style>
:root {
    --purple-dark: #5b2a86;
    --purple-soft: #1f7bb8eb;
    --blue-soft: #8f3f9beb;
    --bg-light: #fdfcff;
    --white: #ffffff;
    --text-dark: #1e1b4b;
    --text-muted: #6b7280;
    --border-soft: #e2e8f0;
    --shadow-soft: 0 10px 25px rgba(91, 42, 134, 0.12);
}

/* Wrapper - centers everything */
.edit-profile-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: calc(100vh - 60px);
    padding: 20px;
    box-sizing: border-box;
}

/* Container - compact laptop size */
.edit-profile-container {
    width: 750px;
    max-width: 100%;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: var(--shadow-soft);
    background: var(--bg-light);
    border: 1px solid rgba(226, 232, 240, 0.6);
}

/* Heading */
.edit-profile-container h2 {
    font-size: 1.6rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--purple-dark);
    border-bottom: 2px solid rgba(91, 42, 134, 0.1);
    padding-bottom: 12px;
}

/* Alerts */
.alert {
    padding: 10px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 500;
    font-size: 0.95rem;
    border-left: 4px solid;
}

.alert.success {
    background: #f0f9ff;
    color: #0369a1;
    border-left-color: #0284c7;
}

.alert.error {
    background: #fff1f2;
    color: #9f1239;
    border-left-color: #e11d48;
}

/* Form rows - 2 columns */
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.form-group.half {
    flex: 1;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 5px;
    color: var(--text-dark);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.form-group label span {
    color: #e11d48;
}

/* Inputs */
.form-group input[type="text"],
.form-group input[type="email"],
.form-group textarea {
    padding: 10px 14px;
    border: 1.5px solid var(--border-soft);
    border-radius: 8px;
    font-size: 0.95rem;
    color: var(--text-dark);
    outline: none;
    transition: all 0.2s ease;
    background: var(--white);
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--purple-dark);
    box-shadow: 0 0 0 3px rgba(91, 42, 134, 0.08);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

/* Logo section */
.logo-section {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.logo-preview img {
    height: 60px;
    width: auto;
    border-radius: 8px;
    border: 2px solid var(--border-soft);
    padding: 4px;
    background: white;
}

/* File input styling */
.file-input {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

.file-label {
    background: white;
    border: 1.5px solid var(--purple-soft);
    color: var(--purple-soft);
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-block;
}

.file-label:hover {
    background: var(--purple-soft);
    color: white;
}

/* Form actions */
.form-actions {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    border-top: 1px solid var(--border-soft);
    padding-top: 20px;
}

/* Save Button */
.btn-save {
    background: linear-gradient(135deg, var(--purple-dark), #6d3a9c);
    color: #fff;
    padding: 10px 28px;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    letter-spacing: 0.3px;
}

.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(91, 42, 134, 0.25);
}

/* Responsive */
@media (max-width: 640px) {
    .edit-profile-wrapper {
        padding: 15px;
        align-items: flex-start;
    }
    
    .edit-profile-container {
        padding: 20px;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .edit-profile-container h2 {
        font-size: 1.4rem;
    }
}
</style>
@endsection