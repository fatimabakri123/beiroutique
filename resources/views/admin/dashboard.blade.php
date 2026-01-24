@extends('admin.layout')
@section('title','Dashboard')

@section('content')

{{-- ================= Stats Cards ================= --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-purple">
            <i class="fas fa-users"></i>
            <div>
                <p>Total Customers</p>
                <h3>{{ $customerCount ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-blue">
            <i class="fas fa-store"></i>
            <div>
                <p>Total Shops</p>
                <h3>{{ $shopCount ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-green">
            <i class="fas fa-box"></i>
            <div>
                <p>Total Products</p>
                <h3>{{ $productCount ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-orange">
            <i class="fas fa-shopping-cart"></i>
            <div>
                <p>Total Orders</p>
                <h3>{{ $orderCount ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- ================= Sales Chart ================= --}}
<div class="card p-4 shadow-sm mb-4">
    <h6 class="mb-3">Sales Overview (Last 7 Days)</h6>
    <canvas id="salesChart" height="120"></canvas>
</div>

{{-- ================= Circular Charts Section ================= --}}
<div class="row g-4">

    {{-- Platform Overview --}}
    <div class="col-md-4">
        <div class="card p-4 shadow-sm text-center">
            <h6 class="mb-3">Platform Overview</h6>
            <canvas id="platformChart"></canvas>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-md-4">
        <div class="card p-4 shadow-sm text-center">
            <h6 class="mb-3">Top Selling Products</h6>
            <canvas id="productsChart"></canvas>
        </div>
    </div>

    {{-- Top Shops --}}
    <div class="col-md-4">
        <div class="card p-4 shadow-sm text-center">
            <h6 class="mb-3">Top Shops by Sales</h6>
            <canvas id="shopsChart"></canvas>
        </div>
    </div>

</div>

@endsection

{{-- ================= Scripts ================= --}}
@push('scripts')
<script>

/* ===== Sales Bar ===== */
new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($salesLabels ?? []) !!},
        datasets: [{
            data: {!! json_encode($salesData ?? []) !!},
            backgroundColor: '#4f46e5',
            borderRadius: 8
        }]
    },
    options: { plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true } } }
});

/* ===== Platform Overview ===== */
new Chart(document.getElementById('platformChart'), {
    type: 'doughnut',
    data: {
        labels: ['Customers','Shops','Products','Orders'],
        datasets: [{
            data: [
                {{ $customerCount ?? 0 }},
                {{ $shopCount ?? 0 }},
                {{ $productCount ?? 0 }},
                {{ $orderCount ?? 0 }}
            ],
            backgroundColor: ['#7c3aed','#2563eb','#16a34a','#f97316']
        }]
    },
    options:{ cutout:'70%', plugins:{ legend:{ position:'bottom' } } }
});

/* ===== Top Products ===== */
new Chart(document.getElementById('productsChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(collect($topProductsList ?? [])->pluck('product_name')) !!},
        datasets: [{
            data: {!! json_encode(collect($topProductsList ?? [])->pluck('sold_qty')) !!},
            backgroundColor: ['#6366f1','#8b5cf6','#ec4899','#f97316','#22c55e']
        }]
    },
    options:{ cutout:'70%', plugins:{ legend:{ position:'bottom' } } }
});

/* ===== Top Shops ===== */
new Chart(document.getElementById('shopsChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(collect($topShopsList ?? [])->pluck('shop_name')) !!},
        datasets: [{
            data: {!! json_encode(collect($topShopsList ?? [])->pluck('total_revenue')) !!},
            backgroundColor: ['#0ea5e9','#22c55e','#facc15','#f97316','#a855f7']
        }]
    },
    options:{ cutout:'70%', plugins:{ legend:{ position:'bottom' } } }
});

</script>
@endpush

{{-- ================= Styles ================= --}}
@push('styles')
<style>
.stat-card{
    display:flex;
    gap:15px;
    align-items:center;
    padding:22px;
    border-radius:18px;
    color:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}
.stat-card i{ font-size:32px; opacity:.9 }
.stat-card p{ margin:0;font-size:14px }
.stat-card h3{ margin:4px 0 0;font-weight:700 }

.stat-purple{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
.stat-blue{background:linear-gradient(135deg,#2563eb,#60a5fa)}
.stat-green{background:linear-gradient(135deg,#16a34a,#4ade80)}
.stat-orange{background:linear-gradient(135deg,#f97316,#fdba74)}
</style>
@endpush
