@extends('Layout.app')
@section('title', 'Sales')
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="h3 mb-4">Sales Management</h1>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-primary text-white rounded">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="display-6">₱ {{ number_format(array_sum(array_column($data, 'total_sales')), 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-success text-white rounded">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="display-6">₱
                            {{ number_format(array_sum(array_map(fn($sale) => $sale['retrieve_price'] * $sale['item_sold'], $data)), 2) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-warning text-white rounded">
                        <h5 class="card-title">Total Items Sold</h5>
                        <p class="display-6">{{ number_format(array_sum(array_column($data, 'item_sold'))) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Monthly Sales Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Category Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="categoryDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Items Sold</th>
                            <th class="text-center">Total Sales</th>
                            <th class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $sale)
                            <tr>
                                <td class="text-center">{{ $sale['name'] }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $sale['category'] }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 20px;">
                                        @php
                                            $percentage = min(($sale['item_sold'] / 100) * 100, 100);
                                            $bgClass = $sale['item_sold'] < 10 ? 'bg-warning' : 'bg-success';
                                        @endphp
                                        <div class="progress-bar {{ $bgClass }}" role="progressbar"
                                            style="width: {{ $percentage }}%" aria-valuenow="{{ $sale['item_sold'] }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            {{ $sale['item_sold'] }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">₱ {{ number_format($sale['total_sales'], 2) }}</td>
                                <td class="text-center">{{ date('M d, Y', strtotime($sale['created_at'])) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const salesData = {{ Js::from($data) }};

        // Process monthly sales data
        const monthlySales = salesData.reduce((acc, item) => {
            const month = new Date(item.created_at).toLocaleString('default', {
                month: 'long'
            });
            if (!acc[month]) {
                acc[month] = {
                    total_sales: 0,
                    items_sold: 0
                };
            }
            acc[month].total_sales += parseFloat(item.total_sales);
            acc[month].items_sold += parseInt(item.item_sold);
            return acc;
        }, {});

        // Sort months chronologically
        const months = Object.keys(monthlySales).sort((a, b) => {
            return new Date(Date.parse(a + " 1, 2024")) - new Date(Date.parse(b + " 1, 2024"));
        });

        // Bar Chart for Monthly Sales
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Total Sales (₱)',
                    data: months.map(month => monthlySales[month].total_sales),
                    backgroundColor: '#4B91F1',
                    borderWidth: 1,
                    yAxisID: 'y'
                }, {
                    label: 'Items Sold',
                    data: months.map(month => monthlySales[month].items_sold),
                    backgroundColor: '#82ca9d',
                    borderWidth: 1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toFixed(2);
                            }
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            callback: function(value) {
                                return value + ' items';
                            }
                        }
                    }
                }
            }
        });

        // Donut Chart for Category Distribution
        const categoryData = {};
        salesData.forEach(item => {
            categoryData[item.category] = (categoryData[item.category] || 0) + item.total_sales;
        });

        const categoryCtx = document.getElementById('categoryDistributionChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(categoryData),
                datasets: [{
                    data: Object.values(categoryData),
                    backgroundColor: ['#4B91F1', '#FF6B6B', '#4BC0C0', '#FFCE56', '#9966FF']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label}: ₱${value.toFixed(2)}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
