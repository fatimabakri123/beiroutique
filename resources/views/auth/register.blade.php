<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
:root {
  --purple-dark: #5b2a86;
  --purple-soft: #8a54ff;
  --blue-soft: #1f7bb8;
  --bg-light: #fdfcff;
  --white: #ffffff;
  --text-dark: #1e1b4b;
  --text-muted: #6b7280;
  --border-soft: rgba(226,232,240,0.8);
  --shadow-soft: 0 18px 40px rgba(91, 42, 134, 0.18);
  --gradient-btn: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
  --gradient-btn-hover: linear-gradient(135deg, var(--blue-soft), var(--purple-dark));
  --input-focus-shadow: 0 2px 5px var(--purple-dark);
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: "Poppins", sans-serif;
  background: linear-gradient(135deg, var(--purple-dark)aa, var(--blue-soft)88);
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.register-container {
  display: flex;
  width: 85%;
  max-width: 950px;
  background: var(--white);
  border-radius: 18px;
  box-shadow: var(--shadow-soft);
  overflow: hidden;
  animation: fadeIn 1s ease-in-out;
}

.register-left {
  flex: 1;
  background: var(--bg-light);
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
  color: var(--purple-dark);
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
  border-bottom: 2px solid var(--border-soft);
  padding: 10px 5px;
  font-size: 15px;
  color: var(--text-dark);
  background: transparent;
  transition: all 0.3s ease;
  width: 100%;
}

input:focus, select:focus {
  border-color: var(--purple-dark);
  outline: none;
  box-shadow: var(--input-focus-shadow);
}

select {
  cursor: pointer;
  background: transparent;
  color: var(--text-dark);
}

.form-row {
  display: flex;
  gap: 15px;
}

button.btn {
  padding: 12px;
  background: var(--gradient-btn);
  color: var(--white);
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
  background: var(--gradient-btn-hover);
}

p {
  text-align: center;
  font-size: 14px;
  color: var(--text-muted);
  margin-top: 10px;
}

p a {
  color: var(--purple-dark);
  text-decoration: none;
  font-weight: 600;
}

p a:hover {
  text-decoration: underline;
  color: var(--blue-soft);
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
        <img src="{{ asset('image/beiroutique4.png') }}" alt="Register Image" class="main-photo">
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
                    <input type="text" name="customer_address" placeholder="Address">
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
                <input type="text" name="shop_address" placeholder="Shop Address">
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
