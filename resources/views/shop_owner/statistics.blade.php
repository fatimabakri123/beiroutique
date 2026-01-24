

<div class="container">
    <h1>{{ $shop->shop_name }} - Shop Statistics</h1>

    <!-- Stats Cards -->
    <div class="stats-cards" style="display:flex; gap:20px; margin-bottom:30px;">
        <div style="flex:1; background:#fce8d5; padding:20px; border-radius:10px; text-align:center;">
            <h2>{{ $totalProducts }}</h2>
            <p>Total Products</p>
        </div>
        <div style="flex:1; background:#d5f0fc; padding:20px; border-radius:10px; text-align:center;">
            <h2>{{ $totalOrders }}</h2>
            <p>Total Orders</p>
        </div>
        <div style="flex:1; background:#d5fcda; padding:20px; border-radius:10px; text-align:center;">
            <h2>${{ number_format($totalRevenue, 2) }}</h2>
            <p>Total Revenue</p>
        </div>
        <div style="flex:1; background:#fcd5d5; padding:20px; border-radius:10px; text-align:center;">
            <h2>{{ $lowStock }}</h2>
            <p>Low Stock Products</p>
        </div>
    </div>

    <!-- Charts -->
    <div style="display:flex; gap:30px; flex-wrap:wrap; margin-bottom:30px;">
        <!-- Monthly Revenue -->
        <div style="flex:1; min-width:400px; background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
            <h3>Monthly Revenue</h3>
            <canvas id="revenueChart"></canvas>
        </div>

        <!-- Top Selling Products -->
        <div style="flex:1; min-width:400px; background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
            <h3>Top Selling Products</h3>
            <canvas id="topProductsChart"></canvas>
        </div>
    </div>

    <!-- Low Stock Table -->
    <div style="background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); margin-bottom:30px;">
        <h3>Low Stock Products (<=5)</h3>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#8B5E3C; color:#fff;">
                    <th style="padding:10px;">Product</th>
                    <th style="padding:10px;">Stock</th>
                    <th style="padding:10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products->where('stock_quantity', '<=', 5) as $p)
                <tr>
                    <td>{{ $p->product_name }}</td>
                    <td>{{ $p->stock_quantity }}</td>
                    <td>
                        <button onclick="editProduct({{ $p->product_id }})" style="padding:5px 10px; background:#C08A56; color:#fff; border:none; border-radius:5px; cursor:pointer;">Edit Stock</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Revenue
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($monthlyRevenue as $m)
                    "{{ date('F', mktime(0,0,0,$m->month,1)) }}",
                @endforeach
            ],
            datasets: [{
                label: 'Revenue ($)',
                data: [
                    @foreach($monthlyRevenue as $m)
                        {{ $m->revenue }},
                    @endforeach
                ],
                backgroundColor: '#4e73df',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Top Selling Products
    const topCtx = document.getElementById('topProductsChart').getContext('2d');
    const topProductsChart = new Chart(topCtx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($topProducts as $tp)
                    "{{ $products->where('product_id', $tp->product_id)->first()->product_name }}",
                @endforeach
            ],
            datasets: [{
                label: 'Units Sold',
                data: [
                    @foreach($topProducts as $tp)
                        {{ $tp->total_sold }},
                    @endforeach
                ],
                backgroundColor: ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b'],
            }]
        },
        options: { responsive:true }
    });
</script>




