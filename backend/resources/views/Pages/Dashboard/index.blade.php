@extends('Layout.app')
@section('title', 'Dashboard')
@include('Components.NaBar.navbar')

@section('content')
    <style>
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>

    <div class="container py-4">
        <h1 class="h3 mb-4">Dashboard</h1>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <!-- Users Card -->
            <div class="col">
                <div class="card h-100 bg-primary text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="display-6">{{ $data['usersCount'] ?? 0 }}</p>
                        <a href="/dashboard" class="btn btn-light text-primary mt-2">View All</a>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="col">
                <div class="card h-100 bg-danger text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="display-6">{{ $data['productsCount'] ?? 0 }}</p>
                        <a href="/products" class="btn btn-light text-danger mt-2">View All</a>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="col">
                <div class="card h-100 bg-success text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="display-6">{{ $data['categoriesCount'] ?? 0 }}</p>
                        <a href="/categories" class="btn btn-light text-success mt-2">View All</a>
                    </div>
                </div>
            </div>

            <!-- Sales Card -->
            <div class="col">
                <div class="card h-100 bg-danger text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title">Sales</h5>
                        <p class="display-6">{{ $data['salesCount'] ?? 0 }}</p>
                        <a href="/sales" class="btn btn-light text-danger mt-2">View All</a>
                    </div>
                </div>
            </div>

            <!-- Stocks Card -->
            <div class="col">
                <div class="card h-100 bg-warning text-white border-0">
                    <div class="card-body">
                        <h5 class="card-title">Stocks</h5>
                        <p class="display-6">{{ $data['stocksCount'] ?? 0 }}</p>
                        <a href="/stocks" class="btn btn-light text-warning mt-2">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <!-- Pie Chart for Products -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Products by Price Range</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="productsPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart for Sales -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Monthly Sales</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="salesBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Charts Row -->
        <div class="row g-4">
            <!-- Line Chart for Sales Trends -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Sales Trends</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donut Chart for Categories -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Products by Category</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="categoriesDonutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Products Pie Chart
        const productsData = @json($data['products'] ?? []);
        const priceRanges = {
            '0-50': 0,
            '51-100': 0,
            '101-200': 0,
            '201-500': 0,
            '500+': 0
        };

        if (Array.isArray(productsData)) {
            productsData.forEach(product => {
                const price = parseFloat(product.retailed_price);
                if (!isNaN(price)) {
                    if (price <= 50) priceRanges['0-50']++;
                    else if (price <= 100) priceRanges['51-100']++;
                    else if (price <= 200) priceRanges['101-200']++;
                    else if (price <= 500) priceRanges['201-500']++;
                    else priceRanges['500+']++;
                }
            });
        }

        // Initialize Charts
        const ctx1 = document.getElementById('productsPieChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: Object.keys(priceRanges),
                datasets: [{
                    data: Object.values(priceRanges),
                    backgroundColor: ['#4B91F1', '#FF6B6B', '#4BC0C0', '#FFCE56', '#9966FF']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Sales Bar Chart
        const salesData = @json($data['sales'] ?? []);
        const monthlySales = {};

        if (Array.isArray(salesData)) {
            salesData.forEach(sale => {
                const date = new Date(sale.created_at);
                const monthYear = date.toLocaleString('default', {
                    month: 'short',
                    year: 'numeric'
                });
                const saleAmount = parseFloat(sale.total_sales);
                if (!isNaN(saleAmount)) {
                    monthlySales[monthYear] = (monthlySales[monthYear] || 0) + saleAmount;
                }
            });
        }

        const sortedMonths = Object.keys(monthlySales).sort((a, b) => new Date(a) - new Date(b));

        const ctx2 = document.getElementById('salesBarChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: sortedMonths,
                datasets: [{
                    label: 'Sales',
                    data: sortedMonths.map(month => monthlySales[month]),
                    backgroundColor: '#4B91F1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Sales Trend Line Chart
        const ctx3 = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: sortedMonths,
                datasets: [{
                    label: 'Sales Trend',
                    data: sortedMonths.map(month => monthlySales[month]),
                    borderColor: '#4BC0C0',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Categories Donut Chart
        const categoriesData = @json($data['categories'] ?? []);
        const categoryCount = {};

        if (Array.isArray(categoriesData)) {
            categoriesData.forEach(cat => {
                categoryCount[cat.category] = (categoryCount[cat.category] || 0) + 1;
            });
        }

        const ctx4 = document.getElementById('categoriesDonutChart').getContext('2d');
        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: Object.keys(categoryCount),
                datasets: [{
                    data: Object.values(categoryCount),
                    backgroundColor: ['#FF6B6B', '#4BC0C0', '#FFCE56', '#9966FF', '#4B91F1']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });
    </script>
@endsection
