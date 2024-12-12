@extends('Layout.app')
@section('title', 'Category')
@include('Components.NaBar.navbar')
@section('content')
    <div class="container my-4">
        <h2 class="mb-4">Categories</h2>

        <div class="row g-4">
            @forelse ($data as $item)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="card-title mb-3">{{ $item['name'] }}</h5>
                                <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $item['id'] }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i>
                                    Edit
                                </button>
                            </div>

                            <div class="mb-3">
                                <span class="badge bg-primary">{{ $item['category'] }}</span>
                            </div>

                            <div
                                class="d-flex align-items-center gap-2
                            @if (!isset($item['stock']) || $item['stock'] == 0) text-danger
                            @elseif($item['stock'] < 50)
                                text-warning
                            @else
                                text-success @endif
                        ">
                                <i class="fas fa-box-open"></i>
                                <span>
                                    @if (!isset($item['stock']) || $item['stock'] == 0)
                                        Out of Stock
                                    @else
                                        {{ $item['stock'] }} in stock
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        No categories found.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <!-- Initialize tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
