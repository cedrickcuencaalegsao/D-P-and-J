@extends('Layout.app')
@section('title', 'Reports')
@include('Components.NaBar.navbar')
@section('content')
    <div class="container py-4">
        <h1 class="h3 mb-4">Sales Reports</h1>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Sales Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-primary text-white rounded">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="display-6">₱ {{ number_format(array_sum(array_column($data, 'total_sales')), 2) }}</p>
                    </div>
                </div>
            </div>
            <!-- Total Items Sold Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-success text-white rounded">
                        <h5 class="card-title">Total Items Sold</h5>
                        <p class="display-6">{{ number_format(array_sum(array_column($data, 'item_sold'))) }}</p>
                    </div>
                </div>
            </div>
            <!-- Average Sale Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-warning text-white rounded">
                        <h5 class="card-title">Average Sale</h5>
                        <p class="display-6">₱
                            {{ number_format(array_sum(array_column($data, 'total_sales')) / count($data), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4">
            <!-- Monthly Sales Chart -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Monthly Sales Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthlySalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quarterly Sales Chart -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Quarterly Sales Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="quarterlySalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Annual Sales Chart -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Annual Sales Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="annualSalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const salesData = @json($data);

        // Process sales data by time periods
        const monthlySales = {};
        const quarterlySales = {};
        const annualSales = {};

        salesData.forEach(sale => {
            const date = new Date(sale.created_at);

            // Monthly
            const monthKey = date.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            if (!monthlySales[monthKey]) monthlySales[monthKey] = 0;
            monthlySales[monthKey] += parseFloat(sale.total_sales);

            // Quarterly
            const quarter = Math.floor(date.getMonth() / 3) + 1;
            const quarterKey = `Q${quarter} ${date.getFullYear()}`;
            if (!quarterlySales[quarterKey]) quarterlySales[quarterKey] = 0;
            quarterlySales[quarterKey] += parseFloat(sale.total_sales);

            // Annual
            const yearKey = date.getFullYear().toString();
            if (!annualSales[yearKey]) annualSales[yearKey] = 0;
            annualSales[yearKey] += parseFloat(sale.total_sales);
        });

        // Chart configurations
        const chartConfig = (data, label) => ({
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: label,
                    data: Object.values(data),
                    backgroundColor: '#4B91F1',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '₱' + value.toLocaleString()
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => '₱' + context.raw.toLocaleString()
                        }
                    }
                }
            }
        });

        // Initialize charts
        new Chart(
            document.getElementById('monthlySalesChart').getContext('2d'),
            chartConfig(monthlySales, 'Monthly Sales')
        );

        new Chart(
            document.getElementById('quarterlySalesChart').getContext('2d'),
            chartConfig(quarterlySales, 'Quarterly Sales')
        );

        new Chart(
            document.getElementById('annualSalesChart').getContext('2d'),
            chartConfig(annualSales, 'Annual Sales')
        );
    </script>

    <style>
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
@endsection
