@extends('shop_owner.layout')

@section('content')

<div class="container">
@if(session('success'))
    <div id="flash-message" 
         style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:5px; margin-bottom:20px; border:1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

<h2 class="shop-title">{{ $shop->shop_name }} Statistics</h2>

<!-- Stats Cards - Match Dashboard Styling -->
<div class="stats-cards">
    <div class="stat-card">
        <h3>${{ number_format($todayRevenue, 2) }}</h3>
        <p>Today's Revenue</p>
    </div>
    <div class="stat-card">
        <h3>{{ $todayOrders }}</h3>
        <p>Orders Today</p>
    </div>
    <div class="stat-card">
        <h3>{{ $pendingOrders }}</h3>
        <p>Pending Orders</p>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section">
    <!-- Chart Row 1 -->
    <div class="charts-row">
        <div class="chart-box">
            <h4 class="chart-title">Monthly Revenue</h4>
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="chart-box">
            <h4 class="chart-title">Top Products</h4>
            <canvas id="topChart"></canvas>
        </div>
    </div>

    <!-- Chart Row 2 -->
    <div class="charts-row">
        <div class="chart-box">
            <h4 class="chart-title">Last 7 Days Orders</h4>
            <canvas id="dailyOrdersChart"></canvas>
        </div>
        <div class="chart-box">
            <h4 class="chart-title">Last 7 Days Revenue</h4>
            <canvas id="dailyRevenueChart"></canvas>
        </div>
    </div>

   <!-- Chart Row 3 -->
<div class="charts-row">
    <div class="chart-box">
        <h4 class="chart-title">Customers Distribution by City</h4>
        <div class="pie-container">
            <canvas id="customerCityChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <h4 class="chart-title">Daily Customers: New vs Returning</h4>
        <canvas id="customerTypeChart"></canvas>
    </div>
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
    const cityLabels = @json($cityLabels);
    const cityData = @json($cityData);

    // Calculate growth % for monthly chart
    const growth = monthlyRevenue.map((val, i, arr) => {
        if (i === 0) return 0;
        return (((val - arr[i - 1]) / arr[i - 1]) * 100).toFixed(1);
    });

    // 1. Monthly Revenue - Line Chart with detailed tooltip
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Revenue',
                data: monthlyRevenue,
                borderColor: '#5b2a86', // Your purple-dark
                backgroundColor: 'rgba(91, 42, 134, 0.15)',
                tension: 0.3,
                fill: true,
                pointRadius: 6,
                pointHoverRadius: 8,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1e1b4b',
                    bodyColor: '#1e1b4b',
                    borderColor: '#5b2a86',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const index = context.dataIndex;
                            const change = growth[index];

                            if (index === 0) {
                                return `Revenue: $${value.toLocaleString()}`;
                            }

                            const arrow = change >= 0 ? '↑' : '↓';
                            return `Revenue: $${value.toLocaleString()} (${arrow} ${Math.abs(change)}%)`;
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14
                        },
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // 2. Top Products - Horizontal Bar Chart with tooltip
    new Chart(document.getElementById('topChart'), {
        type: 'bar',
        data: {
            labels: topLabels,
            datasets: [{
                label: 'Units Sold',
                data: topData,
                backgroundColor: '#1f7bb8eb', // Your purple-soft/blue-soft
                barThickness: 30,
                borderRadius: 8,
                hoverBackgroundColor: '#5b2a86' // Darker on hover
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1e1b4b',
                    bodyColor: '#1e1b4b',
                    borderColor: '#5b2a86',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return `Sold: ${context.raw} units`;
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                x: { 
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                y: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            interaction: {
                intersect: true,
                mode: 'index'
            }
        }
    });

    // 3. Daily Orders - Vertical Bar Chart with tooltip
    new Chart(document.getElementById('dailyOrdersChart'), {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Orders',
                data: dailyOrders,
                backgroundColor: '#8f3f9beb', // Your accent color
                barThickness: 30,
                borderRadius: 8,
                hoverBackgroundColor: '#5b2a86' // Darker on hover
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    display: false 
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1e1b4b',
                    bodyColor: '#1e1b4b',
                    borderColor: '#5b2a86',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        },
                        label: function(context) {
                            return `Orders: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    precision: 0,
                    ticks: {
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: { 
                    grid: { 
                        drawTicks: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                }
            },
            interaction: {
                intersect: true,
                mode: 'index'
            }
        }
    });

    // 4. Daily Revenue - Line Chart with tooltip
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
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    display: true,
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1e1b4b',
                    bodyColor: '#1e1b4b',
                    borderColor: '#5b2a86',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return `Revenue: $${context.raw.toLocaleString()}`;
                        }
                    }
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14
                        },
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // 5. Customer City Distribution - Pie Chart with tooltip
    new Chart(document.getElementById('customerCityChart'), {
        type: 'pie',
        data: {
            labels: cityLabels,
            datasets: [{
                label: 'Customers per City',
                data: cityData,
                backgroundColor: [
                    '#5b2a86', '#1f7bb8eb', '#8f3f9beb', '#1cc88a', '#36b9cc', 
                    '#f6c23e', '#e74a3b', '#858796', '#e83e8c', '#fd7e14'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1e1b4b',
                    bodyColor: '#1e1b4b',
                    borderColor: '#5b2a86',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} customers (${percentage}%)`;
                        }
                    }
                }
            },
            interaction: {
                intersect: true,
                mode: 'point'
            }
        }
    });

    // Flash message fade out
    const flash = document.getElementById('flash-message');
    if(flash){
        setTimeout(() => {
            flash.style.transition = "opacity 0.5s ease";
            flash.style.opacity = 0;
            setTimeout(() => flash.remove(), 500);
        }, 3000);
    }
});

// Add this with your other JavaScript data at the top
const customerTypeDates = @json($customerTypeData['dates']);
const newCustomers = @json($customerTypeData['new_customers']);
const returningCustomers = @json($customerTypeData['returning_customers']);

// 6. New vs Returning Customers - Stacked Bar Chart
new Chart(document.getElementById('customerTypeChart'), {
    type: 'bar',
    data: {
        labels: customerTypeDates,
        datasets: [
            {
                label: 'New Customers',
                data: newCustomers,
                backgroundColor: '#5b2a86', // Purple
                borderColor: '#5b2a86',
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.6
            },
            {
                label: 'Returning Customers',
                data: returningCustomers,
                backgroundColor: '#1f7bb8eb', // Blue
                borderColor: '#1f7bb8eb',
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                titleColor: '#1e1b4b',
                bodyColor: '#1e1b4b',
                borderColor: '#5b2a86',
                borderWidth: 1,
                cornerRadius: 8,
                padding: 12,
                mode: 'index',
                intersect: true,
                callbacks: {
                    label: function(context) {
                        const label = context.dataset.label || '';
                        const value = context.raw || 0;
                        const total = context.chart.data.datasets
                            .map(dataset => dataset.data[context.dataIndex])
                            .reduce((a, b) => a + b, 0);
                        const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            },
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 14
                    },
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                stacked: true, // THIS MAKES IT STACKED
                title: {
                    display: true,
                    text: 'Number of Customers',
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    color: '#1e1b4b'
                },
                ticks: {
                    font: {
                        size: 12
                    },
                    precision: 0,
                    stepSize: 1
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                stacked: true, // THIS MAKES IT STACKED
                title: {
                    display: true,
                    text: 'Last 7 Days',
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    color: '#1e1b4b'
                },
                ticks: {
                    font: {
                        size: 12
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                    drawTicks: false
                }
            }
        },
        interaction: {
            intersect: true,
            mode: 'index'
        }
    }
});
</script>

<style>
:root {
    --primary: #5b2a86;
    --secondary: #1f7bb8eb;
    --accent: #8f3f9beb;
    --bg-light: #f5f7fb;
    --white: #ffffff;
    --text-dark: #1e1b4b;
    --text-muted: #6b7280;
    --border-soft: rgba(226,232,240,0.8);
    --shadow-soft: 0 12px 30px rgba(91, 42, 134, 0.15);
}

.container {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 20px;
    box-sizing: border-box;
}

/* Page Title - BIGGER like dashboard */
.shop-title {
    font-size: 2.5rem !important; /* Much bigger title */
    font-weight: 700 !important;
    color: var(--primary) !important;
    margin-bottom: 40px !important;
    text-align: left !important;
    letter-spacing: 0.5px;
}

/* Stats Cards - EXACTLY like dashboard */
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.stat-card {
    background: #fff;
    padding: 35px 30px; /* More padding */
    border-radius: 14px;
    text-align: center;
    box-shadow: var(--shadow-soft);
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.stat-card h3 {
    font-size: 3rem !important; /* Bigger numbers like dashboard */
    color: var(--secondary) !important;
    margin-bottom: 12px !important;
    font-weight: 700 !important;
}

.stat-card p {
    font-size: 1.4rem !important; /* Bigger text like dashboard */
    color: #555 !important;
    font-weight: 500 !important;
    margin: 0 !important;
}

/* Charts Section */
.charts-section {
    width: 100%;
}

.charts-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-bottom: 25px;
}

/* Chart Boxes - Match Dashboard Table Container */
.chart-box {
    background: #fff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: var(--shadow-soft);
    margin-bottom: 25px;
}

.chart-box.full-width {
    grid-column: span 2;
}

/* Chart Titles - BIGGER like dashboard headers */
.chart-title {
    font-size: 1.5rem !important; /* Bigger chart titles */
    font-weight: 600 !important;
    color: var(--primary) !important;
    margin-bottom: 20px !important;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--border-soft);
}

/* Chart Canvas */
.chart-box canvas {
    width: 100% !important;
    height: 300px !important; /* Fixed height for consistency */
}

/* Pie Chart Container */
.pie-container {
    width: 100%;
    max-width: 400px;
    height: 400px;
    margin: 0 auto;
}

.pie-container canvas {
    width: 100% !important;
    height: 100% !important;
}

/* Flash Message */
#flash-message {
    background: #d4edda;
    color: #155724;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    border: 1px solid #c3e6cb;
    font-size: 1.1rem;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 992px) {
    .charts-row {
        grid-template-columns: 1fr;
    }
    
    .chart-box.full-width {
        grid-column: span 1;
    }
    
    .stat-card h3 {
        font-size: 2.5rem !important;
    }
    
    .stat-card p {
        font-size: 1.2rem !important;
    }
}

@media (max-width: 768px) {
    h2 {
        font-size: 2rem !important;
    }
    
    .stats-cards {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 25px 20px;
    }
    
    .chart-box {
        padding: 20px 15px;
    }
    
    .chart-title {
        font-size: 1.3rem !important;
    }
}


/* Dual Charts Layout */
.dual-charts-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    width: 100%;
}

.half-chart {
    width: 100%;
}

.pie-container,
.line-container {
    width: 100%;
    height: 400px;
    position: relative;
}

.pie-container canvas,
.line-container canvas {
    width: 100% !important;
    height: 100% !important;
}

/* Make sure the full-width chart box has proper padding */
.chart-box.full-width {
    padding: 25px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .dual-charts-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .half-chart {
        margin-bottom: 0;
    }
}

@media (max-width: 768px) {
    .dual-charts-container {
        gap: 30px;
    }
    
    .pie-container,
    .line-container {
        height: 350px;
    }
    
    .chart-box.full-width {
        padding: 20px 15px;
    }
}

.pie-container {
    width: 100%;
    height: 400px;
    position: relative;
}
#customerTypeChart {
    width: 100% !important;
    height: 400px !important;
}

</style>

@endsection