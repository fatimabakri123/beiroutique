<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Beiroutique</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        /* ===== VARIABLES & RESET ===== */
        :root {
            --primary-purple: #5b2a86;
            --primary-blue: #1f7bb8;
            --accent-gold: #d4af37;
            --accent-pink: #ff4d94;
            --dark-bg: #0f0f1e;
            --light-bg: #f9f9f9;
            --glass-white: rgba(255, 255, 255, 0.95);
            --glass-dark: rgba(15, 15, 30, 0.95);
            --shadow-soft: 0 8px 32px rgba(0, 0, 0, 0.1);
            --shadow-hard: 0 20px 60px rgba(91, 42, 134, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #f0f4f8 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(91, 42, 134, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(31, 123, 184, 0.08) 0%, transparent 50%);
            z-index: -1;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(-5deg); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        @keyframes slideIn {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes scanning {
            0% { top: 0; }
            50% { top: 100%; }
            100% { top: 0; }
        }

        /* ===== NAVBAR ===== */
       
        /* ===== HERO SECTION ===== */
        .hero {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 90vh;
            min-height: 600px;
            background: linear-gradient(135deg, #5b2a86 0%, #1f7bb8 50%, #5b2a86 100%);
            background-size: 300% 300%;
            animation: gradientShift 8s ease infinite;
            color: #fff;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            margin-top: 90px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 4px 8px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.4rem;
            max-width: 700px;
            margin: 0 auto 30px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.2);
            animation: fadeInUp 1s ease 0.2s both;
            opacity: 0.9;
        }

        /* Floating Shapes */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 {
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d);
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #6bcf7f, #4d96ff);
            bottom: 20%;
            right: 10%;
            animation-delay: 1s;
            animation-name: float-slow;
        }

        .shape-3 {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #c44569, #574b90);
            top: 40%;
            right: 20%;
            animation-delay: 2s;
        }

        /* ===== SECTIONS ===== */
        .section {
            max-width: 1200px;
            margin: 120px auto;
            padding: 0 30px;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #5b2a86, #1f7bb8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            display: inline-block;
        }

        .section h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #5b2a86, #1f7bb8);
            border-radius: 2px;
        }

        .section-content {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }

        .section-content:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 80px rgba(91, 42, 134, 0.15);
        }

        .section p {
            font-size: 1.15rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .section-img {
            width: 100%;
            max-width: 600px;
            border-radius: 20px;
            margin: 40px auto;
            display: block;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: perspective(1000px) rotateY(-5deg);
            transition: transform 0.5s ease;
        }

        .section-img:hover {
            transform: perspective(1000px) rotateY(0deg);
        }

        /* ===== VALUES SECTION ===== */
        .values {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .value-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.6));
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.7s;
        }

        .value-card:hover::before {
            left: 100%;
        }

        .value-card:hover {
            transform: translateY(-20px) scale(1.05);
            box-shadow: 0 25px 50px rgba(91, 42, 134, 0.2);
        }

        .value-card i {
            font-size: 3.5rem;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #5b2a86, #1f7bb8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        .value-card h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #2d3748;
        }

        .value-card p {
            color: #4a5568;
            font-size: 1rem;
        }

        /* ===== TEAM SECTION ===== */
        .team {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 50px;
            margin-top: 60px;
        }

        .team-member {
            background: white;
            border-radius: 25px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .team-member::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #5b2a86, #1f7bb8);
            transform: scaleX(0);
            transition: transform 0.5s ease;
        }

        .team-member:hover::after {
            transform: scaleX(1);
        }

        .team-member:hover {
            transform: translateY(-15px);
            box-shadow: 0 30px 60px rgba(91, 42, 134, 0.2);
        }

        .team-member-img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 25px;
            border: 5px solid transparent;
            background: linear-gradient(45deg, #5b2a86, #1f7bb8) border-box;
            position: relative;
            transition: transform 0.5s ease;
        }

        .team-member:hover .team-member-img {
            transform: scale(1.1) rotate(5deg);
        }

        .team-member h4 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #2d3748;
        }

        .team-member p {
            color: #1f7bb8;
            font-size: 1rem;
            font-weight: 600;
        }

        /* ===== BACK HOME BUTTON ===== */
        .back-home {
            text-align: center;
            margin: 80px auto;
            position: relative;
        }

        .back-home a {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 50px;
            background: linear-gradient(135deg, #5b2a86, #1f7bb8);
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(91, 42, 134, 0.3);
            position: relative;
            overflow: hidden;
        }

        .back-home a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.7s;
        }

        .back-home a:hover::before {
            left: 100%;
        }

        .back-home a:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(91, 42, 134, 0.4);
            letter-spacing: 1px;
        }

        .back-home a i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .back-home a:hover i {
            transform: translateX(-5px);
        }

        /* ===== FOOTER ===== */
        .shein-footer {
            background: linear-gradient(135deg, #972cba 0%, #1f1fc9b9 100%);
            color: #fff;
            padding: 80px 5% 30px;
            margin-top: 100px;
            position: relative;
            overflow: hidden;
        }

        .shein-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }

        /* Footer Floating Shapes */
        .footer-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }

        .footer-shape-1 {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, var(--accent-pink), var(--accent-gold));
            top: -100px;
            left: 10%;
            animation-delay: 0s;
        }

        .footer-shape-2 {
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
            bottom: 20%;
            right: 15%;
            animation-delay: 2s;
        }

        /* Footer Top */
        .footer-top {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .footer-column {
            padding: 25px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.5s ease, background 0.5s ease;
        }

        .footer-column:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .footer-column h4 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            color: white;
            position: relative;
            padding-bottom: 15px;
        }

        .footer-column h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-gold), var(--accent-pink));
            border-radius: 2px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 15px;
        }

        .footer-column ul li a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-column ul li a::before {
            content: '→';
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .footer-column ul li a:hover {
            color: white;
            transform: translateX(10px);
        }

        .footer-column ul li a:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        /* Social Icons */
        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1.5rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .social-icons a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }

        .social-icons a:hover::before {
            left: 100%;
        }

        .social-icons a:hover {
            transform: translateY(-5px) scale(1.1);
            background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
        }

        /* Newsletter */
        .newsletter-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .newsletter-form input {
            padding: 15px 20px;
            border: none;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .newsletter-form input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent-gold);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }

        .newsletter-form input::placeholder {
            color: #aaa;
        }

        .newsletter-form button {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--accent-gold), var(--accent-pink));
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .newsletter-form button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }

        .newsletter-form button:hover::before {
            left: 100%;
        }

        .newsletter-form button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        /* Payment Methods */
        .footer-payment {
            text-align: center;
            margin: 50px 0;
            position: relative;
            z-index: 2;
        }

        .footer-payment h4 {
            color: white;
            margin-bottom: 30px;
            font-size: 1.2rem;
        }

        .payment-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .payment-icons img {
            width: 70px;
            height: 45px;
            object-fit: contain;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .payment-icons img:hover {
            transform: translateY(-8px) scale(1.1);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        /* Footer Bottom */
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 2;
        }

        .footer-bottom p {
            color: #aaa;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .hero h1 { font-size: 3.5rem; }
            .section h2 { font-size: 2.8rem; }
            .navbar-container { flex-direction: column; gap: 20px; }
            .nav-search-container { width: 100%; margin: 20px 0; }
            .footer-top { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .navbar-main { padding: 15px 20px; }
            .hero { height: 70vh; min-height: 500px; margin-top: 120px; }
            .hero h1 { font-size: 2.8rem; }
            .hero p { font-size: 1.2rem; }
            .section { margin: 80px auto; }
            .section h2 { font-size: 2.4rem; }
            .section-content { padding: 30px; }
            .search-glass-wrapper { padding: 6px 15px; }
            .submit-btn { padding: 10px 20px; font-size: 0.9rem; }
            .footer-top { grid-template-columns: 1fr; }
            .footer-column { padding: 20px; }
            .values, .team { grid-template-columns: 1fr; gap: 30px; }
            .section-img { transform: none; }
            .floating-shape, .shape-1, .shape-2, .shape-3 { display: none; }
            .payment-icons img { width: 60px; height: 40px; }
        }

        @media (max-width: 480px) {
            .logo-text { font-size: 1.4rem; }
            .hero h1 { font-size: 2.2rem; }
            .hero p { font-size: 1.1rem; }
            .section h2 { font-size: 2rem; }
            .section-content { padding: 20px; }
            .search-suffix { flex-direction: column; gap: 10px; }
            .submit-btn { width: 100%; justify-content: center; }
            .value-card, .team-member { padding: 25px 20px; }
            .back-home a { padding: 15px 30px; font-size: 1rem; }
            .newsletter-form input, .newsletter-form button { width: 100%; }
            .social-icons { justify-content: center; }
        }
    </style>
</head>
<body>


    <!-- ===== HERO ===== -->
    <section class="hero">
        <div class="hero-content">
            <h1>About Beiroutique</h1>
            <p>The ultimate platform connecting all shops in Lebanon with customers, making shopping effortless and accessible for everyone.</p>
        </div>
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </section>

    <!-- ===== WHAT WE DO ===== -->
    <section class="section">
        <div class="section-header">
            <h2>What We Do</h2>
        </div>
        <div class="section-content">
            <img src="{{ asset('image/beiroutique4.png') }}" alt="Beiroutique overview" class="section-img">
            <p>Beiroutique brings all Lebanese shops into one unified online space, revolutionizing how customers discover stores, explore authentic products, and shop conveniently from anywhere in the country.</p>
            <p>We bridge the gap between traditional Lebanese commerce and modern digital shopping, creating a vibrant ecosystem that benefits both shoppers and shop owners.</p>
        </div>
    </section>

    <!-- ===== OUR MISSION ===== -->
    <section class="section">
        <div class="section-header">
            <h2>Our Mission</h2>
        </div>
        <div class="section-content">
            <img src="{{ asset('image/crafted.jpg') }}" alt="Our mission" class="section-img">
            <p>Our mission is to empower Lebanese shop owners with digital presence while giving customers a simple, convenient way to find exactly what they need.</p>
            <p>We're committed to celebrating Lebanon's rich commercial heritage while embracing innovation, supporting local businesses, and preserving the unique character of Lebanese products.</p>
        </div>
    </section>

    <!-- ===== OUR VALUES ===== -->
    <section class="section">
        <div class="section-header">
            <h2>Our Core Values</h2>
        </div>
        <div class="values">
            <div class="value-card">
                <i class="fa fa-users"></i>
                <h4>Community First</h4>
                <p>Building strong connections between shoppers and sellers to foster mutual growth and support within Lebanon's commercial landscape.</p>
            </div>
            <div class="value-card">
                <i class="fa fa-lightbulb"></i>
                <h4>Smart Innovation</h4>
                <p>Implementing cutting-edge solutions that make shopping intuitive, efficient, and enjoyable for everyone in the digital age.</p>
            </div>
            <div class="value-card">
                <i class="fa fa-shield-alt"></i>
                <h4>Unwavering Trust</h4>
                <p>Maintaining a secure, transparent, and reliable platform where both shops and customers can interact with complete confidence.</p>
            </div>
        </div>
    </section>

    <!-- ===== MEET OUR TEAM ===== -->
    <section class="section">
        <div class="section-header">
            <h2>Meet Our Visionaries</h2>
        </div>
        <div class="team">
            <div class="team-member">
                <img src="{{ asset('image/founder1.jpg') }}" alt="Fatima B." class="team-member-img">
                <h4>Fatima B.</h4>
                <p>Co-Founder & CEO</p>
                <p style="color:#666; font-weight:400; margin-top:10px;">Driving our strategic vision and growth</p>
            </div>
            <div class="team-member">
                <img src="{{ asset('image/FATIMAN.jpg') }}" alt="Fatima N." class="team-member-img">
                <h4>Fatima N.</h4>
                <p>Co-Founder & Creative Director</p>
                <p style="color:#666; font-weight:400; margin-top:10px;">Shaping our brand experience and design</p>
            </div>
        </div>
    </section>

    <!-- ===== BACK HOME ===== -->
    <div class="back-home">
        <a href="{{ url('/') }}">
            <i class="fas fa-arrow-left"></i>
            Back to Homepage
        </a>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="shein-footer">
        <div class="footer-shape footer-shape-1"></div>
        <div class="footer-shape footer-shape-2"></div>

        <div class="footer-top">
            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#categories-section"><i class="fa-solid fa-tags"></i> Categories</a></li>
                    <li><a href="#shops"><i class="fa-solid fa-store"></i> Sellers</a></li>
                    <li><a href="{{ url('/bio') }}"><i class="fa-solid fa-info-circle"></i> About</a></li>
                    <li><a href="#contact"><i class="fa-solid fa-envelope"></i> Contact</a></li>
                    <li><a href="#faq"><i class="fa-solid fa-question-circle"></i> FAQ</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="#shipping"><i class="fa-solid fa-truck-fast"></i> Shipping Info</a></li>
                    <li><a href="#returns"><i class="fa-solid fa-rotate-left"></i> Returns & Exchanges</a></li>
                    <li><a href="#payment"><i class="fa-solid fa-credit-card"></i> Payment Options</a></li>
                    <li><a href="#support"><i class="fa-solid fa-headset"></i> 24/7 Support</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Follow Us</h4>
                <p style="color: #ccc; margin-bottom: 20px;">Stay connected with our latest updates</p>
                <div class="social-icons">
                    <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-whatsapp"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-tiktok"></ion-icon></a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Newsletter</h4>
                <p style="color: #ccc; margin-bottom: 20px;">Subscribe for exclusive deals & updates!</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe <i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="footer-payment">
            <h4>Secure Payment Methods</h4>
            <div class="payment-icons">
                <img src="{{asset('image/visa.jpg')}}" alt="Visa">
                <img src="{{asset('image/paypal.jpg')}}" alt="PayPal">
                <img src="{{asset('image/omt.webp')}}" alt="OMT">
                <img src="{{asset('image/mastercard.png')}}" alt="Mastercard">
                <img src="{{asset('image/cash.png')}}" alt="Cash on Delivery">
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 Beiroutique. All Rights Reserved. | Designed with <i class="fa-solid fa-heart" style="color: var(--accent-pink);"></i> in Lebanon</p>
        </div>
    </footer>

    <script>
        // Image Preview Functionality
        const imageInput = document.getElementById('imageSearch');
        const previewContainer = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const textSearch = document.getElementById('textSearch');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update preview image
                    previewImg.src = e.target.result;
                    // Show preview box with animation
                    previewContainer.style.display = 'block';
                    previewContainer.style.animation = 'pulse 2s infinite';
                    
                    // Update placeholder
                    textSearch.placeholder = "Analyzing image...";
                    textSearch.style.opacity = '0.6';
                    
                    // Optional: Auto-submit after scanning effect
                    setTimeout(() => {
                        document.getElementById('mainSearchForm').submit();
                    }, 1500);
                }
                reader.readAsDataURL(file);
            }
        });

        function clearImage() {
            imageInput.value = "";
            previewContainer.style.display = 'none';
            previewContainer.style.animation = '';
            textSearch.placeholder = "Search products, categories, shops...";
            textSearch.style.opacity = '1';
        }

        // Add hover effect to search wrapper
        document.querySelector('.search-glass-wrapper').addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });

        document.querySelector('.search-glass-wrapper').addEventListener('mouseleave', function() {
            if (!this.matches(':focus-within')) {
                this.style.transform = 'translateY(0)';
            }
        });

        // Newsletter form submission
        document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                // Add animation to button
                const btn = this.querySelector('button');
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Subscribed!';
                btn.style.background = 'linear-gradient(135deg, #4CAF50, #45a049)';
                
                setTimeout(() => {
                    btn.innerHTML = 'Subscribe <i class="fa-solid fa-paper-plane"></i>';
                    btn.style.background = 'linear-gradient(135deg, var(--accent-gold), var(--accent-pink))';
                    this.reset();
                }, 2000);
            }
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-main');
            if (window.scrollY > 50) {
                navbar.style.backdropFilter = 'blur(25px)';
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.backdropFilter = 'blur(20px)';
                navbar.style.background = 'var(--glass-white)';
                navbar.style.boxShadow = 'var(--shadow-soft)';
            }
        });

        // Scroll animations for sections
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.section-content, .value-card, .team-member');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                observer.observe(section);
            });
            
            // Floating shapes animation
            const shapes = document.querySelectorAll('.floating-shape');
            shapes.forEach((shape, index) => {
                shape.style.animationDelay = `${index * 2}s`;
            });
        });
    </script>
</body>
</html>