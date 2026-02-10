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
                <h3>{{ number_format($customerCount) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-blue">
            <i class="fas fa-store"></i>
            <div>
                <p>Total Shops</p>
                <h3>{{ number_format($shopCount) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-green">
            <i class="fas fa-box"></i>
            <div>
                <p>Total Products</p>
                <h3>{{ number_format($productCount) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-orange">
            <i class="fas fa-money-bill-wave"></i>
            <div>
                <p>Total Revenue</p>
                <h3>${{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- ================= Charts ================= --}}
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card dashboard-card">
            <h6 class="mb-3">Revenue Overview (Last 7 Days)</h6>
            <canvas id="salesChart" height="120"></canvas>
        </div>
    </div>
    

    

{{-- ================= Top Lists ================= --}}
<div class="row g-4 mb-4">
    {{-- Top Products --}}
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Top Products</h6>
                <span class="badge bg-purple">By Sales</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <tbody>
                        @forelse($topProducts as $index => $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded p-1 text-center" style="width:30px;height:30px;line-height:28px;">
                                        <small class="fw-bold">{{ $index + 1 }}</small>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-truncate" style="max-width:120px">{{ $product->product_name }}</div>
                                        <small class="text-muted">{{ $product->shop->shop_name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold">{{ $product->sold_qty ?? 0 }}</div>
                                <small class="text-success">${{ number_format($product->total_revenue ?? 0, 2) }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">No sales data yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Shops --}}
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Top Shops</h6>
                <span class="badge bg-success">By Revenue</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <tbody>
                        @forelse($topShops as $index => $shop)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded p-1 text-center" style="width:30px;height:30px;line-height:28px;">
                                        <small class="fw-bold">{{ $index + 1 }}</small>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-truncate" style="max-width:120px">{{ $shop->shop_name }}</div>
                                        <small class="text-muted">{{ $shop->total_orders ?? 0 }} orders</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold text-success">${{ number_format($shop->total_revenue ?? 0, 2) }}</div>
                                <small class="text-muted">{{ $shop->total_items_sold ?? 0 }} items</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">No shop sales data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Customers --}}
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Top Customers</h6>
                <span class="badge bg-info">By Spending</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <tbody>
                        @forelse($topCustomers as $index => $customer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded p-1 text-center" style="width:30px;height:30px;line-height:28px;">
                                        <small class="fw-bold">{{ $index + 1 }}</small>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-truncate" style="max-width:120px">{{ $customer->name }}</div>
                                        <small class="text-muted">{{ $customer->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold text-success">${{ number_format($customer->total_spent ?? 0, 2) }}</div>
                                <small class="text-muted">{{ $customer->total_orders ?? 0 }} orders</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">No customer data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ================= Monthly Chart ================= --}}
@if(!empty($monthlyData))
<div class="row g-4">
    <div class="col-12">
        <div class="card dashboard-card">
            <h6 class="mb-3">Last 6 Months Performance</h6>
            <canvas id="monthlyChart" height="100"></canvas>
        </div>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
.stat-card{
    display:flex;
    gap:15px;
    align-items:center;
    padding:22px;
    border-radius:18px;
    color:#fff;
    box-shadow:0 10px 25px rgba(124,77,255,0.08);
    transition: all 0.3s ease;
}
.stat-card:hover{
    transform: translateY(-3px);
    box-shadow:0 14px 35px rgba(124,77,255,0.18);
}
.stat-card i{ font-size:32px; opacity:.9 }
.stat-card p{ margin:0;font-size:14px;font-weight:500; }
.stat-card h3{ margin:4px 0 0;font-weight:700; font-size:22px; }

.stat-purple{background:linear-gradient(135deg,#7b2fae,#a64dd1)}
.stat-blue{background:linear-gradient(135deg,#2563eb,#60a5fa)}
.stat-green{background:linear-gradient(135deg,#16a34a,#4ade80)}
.stat-orange{background:linear-gradient(135deg,#f97316,#fdba74)}

.dashboard-card{
    background:#fff;
    border-radius:18px;
    padding:22px;
    box-shadow:0 10px 25px rgba(124,77,255,0.08);
    height:100%;
}
.dashboard-card h6{
    font-weight:600;
    color:#2c3e50;
    margin-bottom:15px;
    font-size:15px;
    border-bottom:2px solid #f8f9fa;
    padding-bottom:10px;
}

.table tbody tr:hover{
    background-color:#f8f9fa;
}
.table td{
    border:none;
    padding:12px 8px;
}

.badge.bg-purple{
    background-color:#7b2fae !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// 1. Weekly Sales Chart
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($salesLabels ?? []) !!},
        datasets: [{
            label: 'Daily Revenue ($)',
            data: {!! json_encode($salesData ?? []) !!},
            borderColor: '#7b2fae',
            backgroundColor: 'rgba(123, 47, 174, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value;
                    }
                }
            }
        }
    }
});

// 2. Monthly Chart (if data exists)
@if(!empty($monthlyData))
const monthlyLabels = {!! json_encode(array_keys($monthlyData)) !!};
const monthlyRevenue = {!! json_encode(array_column($monthlyData, 'revenue')) !!};
const monthlyOrders = {!! json_encode(array_column($monthlyData, 'orders')) !!};

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: monthlyLabels,
        datasets: [
            {
                label: 'Revenue ($)',
                data: monthlyRevenue,
                backgroundColor: '#7b2fae',
                borderRadius: 6,
                yAxisID: 'y'
            },
            {
                label: 'Orders',
                data: monthlyOrders,
                backgroundColor: '#10b981',
                borderRadius: 6,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                type: 'linear',
                position: 'left',
                ticks: {
                    callback: function(value) {
                        return '$' + value;
                    }
                }
            },
            y1: {
                type: 'linear',
                position: 'right',
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});
@endif
</script>
@endpush