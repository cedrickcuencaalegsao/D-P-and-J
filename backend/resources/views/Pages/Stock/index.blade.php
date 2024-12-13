@extends('Layout.app')
@section('title', 'Stocks')
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
        <h1 class="h3 mb-4">Stock Management</h1>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Stock Levels Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="stockLevelsChart"></canvas>
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

        <!-- Stock Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Stock Level</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $stock)
                            <tr>
                                <td class="text-center">{{ $stock->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $stock->category }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 20px;">
                                        @php
                                            $percentage = min(($stock->getStocks() / 100) * 100, 100);
                                            $bgClass =
                                                $stock->getStocks() == 0
                                                    ? 'bg-danger'
                                                    : ($stock->getStocks() < 50
                                                        ? 'bg-warning'
                                                        : 'bg-success');
                                        @endphp
                                        <div class="progress-bar {{ $bgClass }}" role="progressbar"
                                            style="width: {{ $percentage }}%" aria-valuenow="{{ $stock->getStocks() }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            {{ $stock->getStocks() }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($stock->getStocks() == 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($stock->getStocks() < 50)
                                        <span class="badge bg-warning">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editStockModal{{ $stock->getId() }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                            @include('Components.Modals.editStock')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const stockData =
            {{ Js::from(
                collect($data)->map(
                    fn($stock) => [
                        'name' => $stock->name,
                        'category' => $stock->category,
                        'stocks' => $stock->getStocks(),
                    ],
                ),
            ) }};

        // Bar Chart
        const stockCtx = document.getElementById('stockLevelsChart').getContext('2d');
        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: stockData.map(item => item.name),
                datasets: [{
                    label: 'Current Stock Level',
                    data: stockData.map(item => item.stocks),
                    backgroundColor: stockData.map(item =>
                        item.stocks === 0 ? '#dc3545' :
                        item.stocks < 50 ? '#ffc107' : '#198754'
                    ),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
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

        // Donut Chart
        const categoryData = {};
        stockData.forEach(item => {
            categoryData[item.category] = (categoryData[item.category] || 0) + 1;
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
                    }
                }
            }
        });
    </script>
@endsection
