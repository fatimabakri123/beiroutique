@extends('admin.layout')
@section('title','System Settings')
@section('content')

<div class="container settings-page">
    <h2>System Settings</h2>

    <!-- Payment Methods -->
    <h5 class="mt-4">Payment Methods</h5>
    <div class="card p-3 mb-3">
        <a class="btn btn-purple" href="{{ route('admin.payment_methods.index') }}">
            Manage Payment Methods
        </a>
    </div>

    <!-- Delivery Methods -->
    <h5 class="mt-4">Delivery Methods</h5>
    <div class="card p-3 mb-3">
        <a class="btn btn-purple" href="{{ route('admin.delivery_methods.index') }}">
            Manage Delivery Methods
        </a>
    </div>
</div>

<style>
/* ====== VARIÁVEIS CSS ====== */
:root {
    --purple: #7b2fae;
    --purple-dark: #4b136e;
    --purple-light: #a05cd9;
    --purple-very-light: #f3edff;
    --bg: #f7f8fc;
    --text: #2c2f4a;
    --text-light: #8a8fa3;
    --shadow: 0 10px 25px rgba(123, 47, 174, 0.15);
    --shadow-hover: 0 15px 35px rgba(123, 47, 174, 0.25);
    --border-radius: 20px;
    --card-radius: 15px;
    --btn-radius: 50px;
}

/* ====== RESET & BASE ====== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: var(--bg);
    font-family: 'Poppins', sans-serif;
    color: var(--text);
    line-height: 1.6;
}

/* ====== CONTAINER ====== */
.container.settings-page {
    max-width: 800px;
    margin: 40px auto;
    padding: 40px;
    background: linear-gradient(135deg, #ffffff, var(--purple-very-light));
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
}

.container.settings-page::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, rgba(123, 47, 174, 0.1), rgba(160, 92, 217, 0.05));
    border-radius: 50%;
    z-index: 0;
}

.container.settings-page > * {
    position: relative;
    z-index: 1;
}

/* ====== TIPOGRAFIA ====== */
h2 {
    font-size: 36px;
    font-weight: 800;
    text-align: center;
    background: linear-gradient(135deg, var(--purple), var(--purple-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 40px;
    padding-bottom: 15px;
    position: relative;
}

h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, var(--purple), var(--purple-light));
    border-radius: 2px;
}

h5 {
    font-size: 22px;
    font-weight: 700;
    color: var(--purple-dark);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

h5::before {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    background: var(--purple);
    border-radius: 50%;
}

/* ====== CARDS ====== */
.card {
    border: none;
    border-radius: var(--card-radius);
    box-shadow: var(--shadow);
    background: #ffffff;
    transition: all 0.3s ease;
    padding: 25px;
    position: relative;
    overflow: hidden;
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(to bottom, var(--purple), var(--purple-light));
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.card.p-3 {
    padding: 25px !important;
}

/* ====== BOTÕES ====== */
.btn-purple {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 32px;
    font-weight: 700;
    font-size: 16px;
    border-radius: var(--btn-radius);
    background: linear-gradient(135deg, var(--purple), var(--purple-light));
    color: #ffffff !important;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    min-width: 220px;
}

.btn-purple::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: 0.5s;
}

.btn-purple:hover::before {
    left: 100%;
}

.btn-purple:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(123, 47, 174, 0.4);
    text-decoration: none;
}

.btn-purple:active {
    transform: translateY(-1px) scale(1.02);
}

/* ====== EFEITOS DE ÍCONES (OPCIONAL) ====== */
.btn-purple::after {
    content: '→';
    font-size: 18px;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.btn-purple:hover::after {
    opacity: 1;
    transform: translateX(0);
}

/* ====== ESPAÇAMENTOS ====== */
.mt-4 {
    margin-top: 2rem !important;
}

.mb-3 {
    margin-bottom: 1.5rem !important;
}

/* ====== RESPONSIVO ====== */
@media (max-width: 992px) {
    .container.settings-page {
        max-width: 90%;
        padding: 30px;
    }
}

@media (max-width: 768px) {
    h2 {
        font-size: 30px;
        margin-bottom: 30px;
    }
    
    h2::after {
        width: 80px;
    }
    
    h5 {
        font-size: 20px;
    }
    
    .container.settings-page {
        padding: 25px;
        margin: 20px auto;
    }
    
    .card {
        padding: 20px;
    }
    
    .btn-purple {
        width: 100%;
        text-align: center;
        justify-content: center;
        padding: 12px 24px;
        min-width: auto;
    }
    
    .btn-purple::after {
        display: none;
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 26px;
    }
    
    h5 {
        font-size: 18px;
    }
    
    .container.settings-page {
        padding: 20px;
        border-radius: 15px;
    }
    
    .card {
        padding: 18px;
    }
    
    .btn-purple {
        font-size: 15px;
        padding: 10px 20px;
    }
}

/* ====== ANIMAÇÕES ====== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.container.settings-page {
    animation: fadeIn 0.5s ease-out;
}

.card {
    animation: fadeIn 0.5s ease-out;
    animation-fill-mode: both;
}

.card:nth-child(1) {
    animation-delay: 0.1s;
}

.card:nth-child(2) {
    animation-delay: 0.2s;
}

/* ====== ESTADOS DE FOCO ====== */
.btn-purple:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(123, 47, 174, 0.3);
}

/* ====== TEXTO ALTERNATIVO ====== */
.text-muted {
    color: var(--text-light) !important;
    font-size: 14px;
}

/* ====== BORDA DECORATIVA ====== */
.settings-page {
    border: 1px solid rgba(123, 47, 174, 0.1);
}
</style>

@endsection