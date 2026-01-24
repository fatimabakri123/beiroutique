<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<style>
body {
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #5a1f07a7, #8ec5fc);
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.register-container {
    display: flex;
    width: 85%;
    max-width: 950px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    animation: fadeIn 1s ease-in-out;
}

.register-left {
    flex: 1;
    background: #f8f8fb;
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-left img {
    width: 80%;
    max-width: 400px;
    animation: float 3s ease-in-out infinite;
}

.register-right {
    flex: 1;
    padding: 45px 55px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.register-right h2 {
    font-size: 26px;
    color: #1e1e2f;
    margin-bottom: 25px;
    text-align: center;
    letter-spacing: 0.5px;
}

form {
    display: block;
    flex-direction: column;
    gap: 18px;
}

input, select {
    border: none;
    border-bottom: 2px solid #ddd;
    padding: 10px 5px;
    font-size: 15px;
    color: #333;
    background: transparent;
    transition: all 0.3s ease;
    width: 100%;
}

input:focus, select:focus {
    border-color: #2845d9ff;
    outline: none;
    box-shadow: 0 2px 0 #6d28d9;
}

select {
    cursor: pointer;
    background: transparent;
    color: #555;
}

.form-row {
    display: flex;
    gap: 15px;
}

button.btn {
    padding: 12px;
    background: linear-gradient(135deg, #8ec5fc, #5a1f07a7);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s ease, background 0.3s ease;
    margin-top: 10px;
    letter-spacing: 0.5px;
}

button.btn:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #5a1f07a7, #8ec5fc);
}

p {
    text-align: center;
    font-size: 14px;
    color: #555;
    margin-top: 10px;
}

p a {
    color: #2845d9ff;
    text-decoration: none;
    font-weight: 600;
}

p a:hover {
    text-decoration: underline;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@media (max-width: 850px) {
    .register-container { flex-direction: column; }
    .register-left { display: none; }
    .register-right { padding: 35px 25px; }
}
</style>
</head>
<body>

<div class="register-container">
    <!-- Left Side -->
    <div class="register-left">
        <img src="{{ asset('image/beiroutique3.png') }}" alt="Register Image" class="main-photo">
    </div>

    <!-- Right Side -->
    <div class="register-right">
        <h2>Create Account</h2>
      
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Role -->
            <select name="role" id="role" required>
                <option value="">-- Select Role --</option>
                <option value="customer">Customer</option>
                <option value="shop_owner">Shop Owner</option>
            </select>

            <!-- Common Fields -->
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <input type="text" name="username" placeholder="Username" required>

            <!-- Customer Fields -->
            <div id="customer-fields" data-role="customer" style="display:none;">
                <div class="form-row">
                    <input type="text" name="customer_phone" placeholder="Phone Number">
                    <input type="text" name="address" placeholder="Address">
                </div>
            </div>

            <!-- Shop Owner Fields -->
            <div id="shop-owner-fields" data-role="shop_owner" style="display:none;">
                <div class="form-row">
                    <input type="text" name="owner_phone" placeholder="Phone Number">
                    <input type="text" name="shop_name" placeholder="Shop Name">
                </div>
                <input type="text" name="description" placeholder="Shop Description">
                <input type="file" name="logo_url">
                <input type="email" name="contact_email" placeholder="Contact Email">
                <input type="text" name="contact_phone" placeholder="Contact Phone">
                <input type="text" name="address" placeholder="Shop Address">
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn">Register</button>
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </form>
    </div>
</div>

<script>
const roleSelect = document.getElementById('role');
const allFields = document.querySelectorAll('[data-role]');

roleSelect.addEventListener('change', function() {
    allFields.forEach(div => {
        div.style.display = 'none';
        div.querySelectorAll('input, select').forEach(input => input.required = false);
    });

    const selected = document.querySelector(`[data-role="${this.value}"]`);
    if(selected) {
        selected.style.display = 'block';
        selected.querySelectorAll('input, select').forEach(input => input.required = true);
    }
});
</script>

</body>
</html>
