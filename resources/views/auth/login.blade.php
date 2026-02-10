<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beiroutique Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  
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

/* Reset */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(120deg, var(--purple-dark)a7, var(--blue-soft));
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
    position: relative;
}

/* Animated background circles */
.bg-circle {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle at center, rgba(255,255,255,0.3), transparent);
    animation: float 6s ease-in-out infinite;
}
.bg-circle:nth-child(1) {
    width: 180px; height: 180px;
    top: 15%; left: 10%;
    animation-delay: 0s;
}
.bg-circle:nth-child(2) {
    width: 250px; height: 250px;
    bottom: 10%; right: 8%;
    animation-delay: 3s;
}
@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
    50% { transform: translateY(-25px) scale(1.05); opacity: 0.9; }
}

.login-card {
    width: 500px;
    background: rgba(255, 255, 255, 0.97);
    border-radius: 20px;
    box-shadow: var(--shadow-soft);
    padding: 60px 50px;
    text-align: center;
    backdrop-filter: blur(10px);
    z-index: 5;
    transition: transform 0.5s ease, box-shadow 0.5s ease;
}
.login-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.logo img {
    width: 200px;
   
    margin-bottom: 20px;
    transition: transform 0.6s ease;
}
.login-card:hover .logo img {
    transform: rotate(-5deg) scale(1.05);
}

h2 {
    font-size: 32px;
    font-weight: 600;
    color: var(--purple-dark);
    margin-bottom: 35px;
    letter-spacing: 0.8px;
}

.form-group {
    margin-bottom: 25px;
    text-align: left;
}

label {
    font-size: 15px;
    color: var(--purple-dark);
    margin-bottom: 6px;
    display: block;
    font-weight: 500;
}

input {
    width: 100%;
    padding: 14px 16px;
    border-radius: 12px;
    border: 1px solid var(--border-soft);
    background: var(--white);
    font-size: 16px;
    transition: all 0.3s ease;
}

input:focus {
    border-color: var(--purple-dark);
    box-shadow: 0 0 10px rgba(91, 42, 134, 0.3);
    outline: none;
}

button {
    width: 100%;
    padding: 14px;
    background: linear-gradient(45deg, var(--purple-dark), var(--blue-soft));
    color: var(--white);
    border: none;
    border-radius: 12px;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

button::after {
    content: "";
    position: absolute;
    top: 0; left: -100%;
    width: 100%; height: 100%;
    background: rgba(255,255,255,0.3);
    transition: 0.5s;
}
button:hover::after {
    left: 100%;
}
button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(91, 42, 134, 0.35);
}

.register-link {
    margin-top: 20px;
    font-size: 15px;
    color: var(--purple-dark);
    text-decoration: none;
    transition: 0.3s;
    display: inline-block;
}
.register-link:hover {
    color: var(--blue-soft);
    transform: scale(1.05);
}

.forgot {
    text-align: right;
    margin-top: -10px;
    margin-bottom: 20px;
}

.forgot a {
    font-size: 14px;
    color: var(--purple-dark);
    text-decoration: none;
    transition: 0.3s;
}
.forgot a:hover {
    color: var(--blue-soft);
}

.error-messages {
    background: #ffeaea;
    border-left: 5px solid #ff8080;
    color: #a94442;
    margin-bottom: 15px;
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 14px;
    text-align: left;
}

@media (max-width: 550px) {
    .login-card {
        width: 90%;
        padding: 40px 30px;
    }
    h2 {
        font-size: 26px;
    }
}
</style>


</head>
<body>

<!-- floating background circles -->

<!-- floating background circles -->
<div class="bg-circle"></div>
<div class="bg-circle"></div>

<div class="login-card">
    <div class="logo">
        <img src="{{ asset('image/beiroutique2.png') }}" alt="Beiroutique Logo">
    </div>
    <h2>Welcome Back</h2>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
       
        <input type="hidden" name="redirect" value="{{ request('redirect') }}">

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="forgot">
           <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit">Login</button>
    </form>

    <a href="/register" class="register-link">Don’t have an account? <b>Sign Up</b></a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  
    const savedUrl = localStorage.getItem('redirectAfterLogin');
    if (savedUrl) {
      
        localStorage.removeItem('redirectAfterLogin');
        
      
        const redirectInput = document.querySelector('input[name="redirect"]');
        if (redirectInput && !redirectInput.value) {
            redirectInput.value = savedUrl;
        }
    }
    
  
    const urlParams = new URLSearchParams(window.location.search);
    const redirectParam = urlParams.get('redirect');
    if (redirectParam) {
        const redirectInput = document.querySelector('input[name="redirect"]');
        if (redirectInput) {
            redirectInput.value = redirectParam;
        }
    }
});
</script>

</body>
</html>
