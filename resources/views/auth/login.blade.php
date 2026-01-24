<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beiroutique Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(120deg, #5a1f07a7, #8ec5fc);
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
        box-shadow: 0 15px 50px rgba(0,0,0,0.25);
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
        width: 100px;
        margin-bottom: 20px;
        transition: transform 0.6s ease;
    }

    .login-card:hover .logo img {
        transform: rotate(-5deg) scale(1.05);
    }

    h2 {
        font-size: 32px;
        font-weight: 600;
        color: #5a1f07;
        margin-bottom: 35px;
        letter-spacing: 0.8px;
    }

    .form-group {
        margin-bottom: 25px;
        text-align: left;
    }

    label {
        font-size: 15px;
        color: #5a1f07;
        margin-bottom: 6px;
        display: block;
        font-weight: 500;
    }

    input {
        width: 100%;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid #ccc;
        background: #fdfdfd;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    input:focus {
        border-color: #5a1f07;
        box-shadow: 0 0 10px rgba(90, 31, 7, 0.3);
        outline: none;
    }

    button {
        width: 100%;
        padding: 14px;
        background: linear-gradient(45deg, #5a1f07, #8ec5fc);
        color: #fff;
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
        box-shadow: 0 10px 30px rgba(90, 31, 7, 0.35);
    }

    .register-link {
        margin-top: 20px;
        font-size: 15px;
        color: #5a1f07;
        text-decoration: none;
        transition: 0.3s;
        display: inline-block;
    }

    .register-link:hover {
        color: #8ec5fc;
        transform: scale(1.05);
    }

    .forgot {
        text-align: right;
        margin-top: -10px;
        margin-bottom: 20px;
    }

    .forgot a {
        font-size: 14px;
        color: #5a1f07;
        text-decoration: none;
        transition: 0.3s;
    }

    .forgot a:hover {
        color: #8ec5fc;
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

</body>
</html>
