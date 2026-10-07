@extends('layouts.customer')

@section('content')
<section id="dashboard-home" class="content-section active">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Back Button -->
   

    <h1>Welcome {{ $user->name }} 👋</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fa fa-box"></i>
            <h3>Orders</h3>
            <p>{{ $ordersCount ?? 0 }} Active Orders</p>
        </div>

        <div class="stat-card">
            <a href="{{ route('customer.wishlist') }}" class="stat-link">
                <i class="fa fa-heart"></i>
                <h3>Wishlist</h3>
                <p>{{ $wishlistCount ?? 0 }} Items Saved</p>
            </a>
        </div>

        <div class="stat-card">
            <i class="fa fa-bell"></i>
            <h3>Notifications</h3>
            <p>{{ $notifications->count() ?? 0 }} New Alerts</p>
        </div>
    </div>
    
    <style>
        /* ===== GENERAL ===== */
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2e2e50;
        }

        /* ===== DASHBOARD WRAPPER ===== */
        #dashboard-home {
            padding: 60px 30px 40px;
        }

        /* ===== BACK BUTTON ===== */
        .back-btn-wrapper {
            margin-bottom: 25px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 18px;
            background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
            color: #fff;
            font-weight: 600;
            font-size: 20px;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(124,77,255,0.25);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(96,165,250,0.35);
            color: #fff;
        }

        /* ===== STATS GRID ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        /* ===== STAT CARD ===== */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s, background 0.3s, color 0.3s;
            cursor: pointer;
            position: relative;
        }

        .stat-link {
            display: block;
            text-decoration: none;
            color: inherit;
            width: 100%;
            height: 100%;
        }

        .stat-card i {
            font-size: 28px;
            color: #7e22ce;
            margin-bottom: 12px;
            display: inline-block;
            transition: color 0.3s;
        }

        .stat-card h3 {
            font-size: 25px;
            margin-bottom: 6px;
            color: #1e1e2f;
            transition: color 0.3s;
        }

        .stat-card p {
            font-size: 18px;
            color: #555;
            transition: color 0.3s;
        }

        /* ===== STAT CARD HOVER ===== */
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            background: linear-gradient(135deg, #a080bc, #5b93c7);
            color: #fff;
        }

        .stat-card:hover i,
        .stat-card:hover h3,
        .stat-card:hover p {
            color: #fff;
        }

        /* ===== MAKE LINK VISIBLE ===== */
        .stat-link:hover {
            text-decoration: underline;
            text-decoration-color: rgba(255, 255, 255, 0.5);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            #dashboard-home {
                padding: 40px 20px 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 600px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .back-btn {
                font-size: 18px;
                padding: 8px 16px;
            }
        }
    </style>
</section>
@endsection