@extends('shop_owner.layout')

@section('content')

<div class="container">
@if(session('success'))
    <div id="flash-message" 
         style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:5px; margin-bottom:20px; border:1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

<h2>{{ $shop->shop_name }} Statistics</h2>

<div class="stats-grid">

    <!-- Today's Revenue -->
    <div class="card">
        Today’s Revenue <br>
        <b>${{ number_format($todayRevenue, 2) }}</b>
    </div>

    <!-- Orders Today -->
    <div class="card">
        Orders Today <br>
        <b>{{ $todayOrders }}</b>
    </div>

    <!-- Pending Orders -->
    <div class="card">
        Pending Orders <br>
        <b>{{ $pendingOrders }}</b>
    </div>

</div>

<div class="charts-row">
    <div class="chart-box">
        <h4>Monthly Revenue</h4>
        <canvas id="monthlyChart"></canvas>
    </div>

    <div class="chart-box">
        <h4>Top Products</h4>
        <canvas id="topChart"></canvas>
    </div>
</div>

<div class="charts-row">
    <div class="chart-box">
        <h4>Last 7 Days Orders</h4>
        <canvas id="dailyOrdersChart"></canvas>
    </div>

    <div class="chart-box">
        <h4>Last 7 Days Revenue</h4>
        <canvas id="dailyRevenueChart"></canvas>
    </div>
</div>

<div class="chart-box city-chart-container">
    <h4>Customers Distribution by City</h4>
    <div class="pie-container">
    <canvas id="customerCityChart"></canvas>
    </div>
</div>
</div>
<!-- LOW STOCK -->
<div class="box low-stock-table">
<h4>Low Stock Products</h4>
<table>
<thead>
<tr>
<th>Product</th>
<th>Stock</th>
<th>Action</th> <!-- new column to edit stock -->
</tr>
</thead>
<tbody>
@foreach($products->where('stock_quantity','<=',5) as $p)
<tr>
<td>{{ $p->product_name }}</td>
<td>{{ $p->stock_quantity }}</td>
<td>
    <a href="{{ route('shop.product.edit', $p->product_id) }}" class="edit-btn">Edit Stock</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    
document.addEventListener("DOMContentLoaded", function () {

    const monthlyLabels = @json($monthlyLabels);
    const monthlyRevenue = @json($monthlyRevenue);

    const topLabels = @json($topProductLabels);
    const topData = @json($topProductData);

    const dailyLabels = @json($dailyLabels);
    const dailyOrders = @json($dailyOrders);
    const dailyRevenue = @json($dailyRevenue);

    // Monthly Revenue - Bar Chart

// Calculate growth %
const growth = monthlyRevenue.map((val, i, arr) => {
    if (i === 0) return 0;
    return (((val - arr[i - 1]) / arr[i - 1]) * 100).toFixed(1);
});

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [{
            label: 'Monthly Revenue',
            data: monthlyRevenue,
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.15)',
            tension: 0.3,
            fill: true,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        const value = ctx.raw;
                        const index = ctx.dataIndex;
                        const change = growth[index];

                        if (index === 0) {
                            return `Revenue: $${value}`;
                        }

                        const arrow = change >= 0 ? '↑' : '↓';
                        return `Revenue: $${value} (${arrow} ${Math.abs(change)}%)`;
                    }
                }
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

    // Top Products - Pie Chart
   const topProductLabels = @json($topProductLabels);
const topProductData = @json($topProductData);


console.log(topProductLabels, topProductData); // debug


new Chart(document.getElementById('topChart'), {
type: 'bar',
data: {
labels: topProductLabels,
datasets: [{
label: 'Top Products',
data: topProductData,
backgroundColor: '#4e73df',
barThickness: 25,
borderRadius: 6
}]
},
options: {
indexAxis: 'y',
responsive: true,
scales: {
x: { beginAtZero: true }
}
}
});

    // Last 7 Days Orders - Bar Chart
new Chart(document.getElementById('dailyOrdersChart'), {
    type: 'bar',
    data: {
        labels: dailyLabels,
        datasets: [{
            label: 'Orders',
            data: dailyOrders,
            backgroundColor: '#4e73df',
            barThickness: 25,      // <-- set thickness in pixels
            borderRadius: 6        // optional: rounded edges like your top products
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, precision: 0 },
            x: { grid: { drawTicks: false } }
        }
    }
});

    // Last 7 Days Revenue - Line Chart
    new Chart(document.getElementById('dailyRevenueChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Revenue',
                data: dailyRevenue,
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });

});

document.addEventListener('DOMContentLoaded', function() {
const flash = document.getElementById('flash-message');
if(flash){
setTimeout(() => {
flash.style.transition = "opacity 0.5s ease";
flash.style.opacity = 0;
setTimeout(() => flash.remove(), 500); // remove after fade-out
}, 3000); // 3000ms = 3 seconds
}
});

const cityLabels = @json($cityLabels);
const cityData   = @json($cityData);

new Chart(document.getElementById('customerCityChart'), {
    type: 'pie',
    data: {
        labels: cityLabels,
        datasets: [{
            label: 'Customers per City',
            data: cityData,
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // <-- key change
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<style>
.stats-grid {display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;}
.card,.chart-box{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 10px rgba(0,0,0,.1)}
.charts-row{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:30px}

.low-stock-table {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    margin-top: 30px;
}

.low-stock-table h4 {
    margin-bottom: 15px;
    font-size: 18px;
    color: #333;
}

.low-stock-table table {
    width: 100%;
    border-collapse: collapse;
}

.low-stock-table table th,
.low-stock-table table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.low-stock-table table th {
    background-color: #f6f6f6;
    font-weight: 600;
}

.low-stock-table table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.low-stock-table .edit-btn {
    display: inline-block;
    padding: 5px 10px;
    background-color: #4e73df;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.2s;
}

.low-stock-table .edit-btn:hover {
    background-color: #2e59d9;
}

.city-chart-container {
    width: 100%; /* fills card width */
    padding: 20px;
    box-sizing: border-box;
}

.pie-container {
    width: 100%;          /* take full container width */
    max-width: 500px;     /* limits chart width */
    aspect-ratio: 1 / 1;  /* keeps it square */
    margin: 0 auto;       /* center horizontally */
}

.pie-container canvas {
    width: 100% !important;
    height: 100% !important;
}
</style>

@endsection
