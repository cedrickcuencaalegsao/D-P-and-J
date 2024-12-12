@extends('Layout.app')
@section('title', 'Products')
@include('Components.NaBar.navbar')
@section('content')
    <div class="container">
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
        <!-- Category filter buttons -->
        <div class="mb-4">
            <button class="btn btn-primary me-2" onclick="filterProducts('all')">All</button>
            @php
                $categories = collect($data)->pluck('category')->unique();
            @endphp

            @foreach ($categories as $category)
                <button class="btn btn-outline-primary me-2" onclick="filterProducts('{{ $category }}')">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4" id="products-container">
            {{-- {{ dd($data) }} --}}
            @forelse ($data as $product)
                {{-- {{ dd($product['product_id']) }} --}}
                <div class="col product-item" data-category="{{ $product['category'] }}">
                    <x-cards.card :product_id="$product['product_id']" :title="$product['name']" :category="$product['category'] ?? ''" :image="$product['image'] ?? ''" :retailed_price="$product['retailed_price'] ?? 0"
                        :price="$product['retrieve_price'] ?? 0" />
                </div>
            @empty
                <div class="col">
                    <p>No products found.</p>
                </div>
            @endforelse
        </div>
        <div class="floating-button">
            <button class="btn btn-primary rounded-circle" onclick="openAddProductModal()">
                + <!-- Font Awesome plus icon -->
            </button>
        </div>
        @include('Components.Modals.addProduct')
        @include('Components.Modals.editProducts')

        <style>
            .floating-button {
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 1000;
            }

            .floating-button button {
                width: 50px;
                height: 50px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                transition: all 0.3s ease;
                display: flex;
                /* Added for centering the icon */
                align-items: center;
                /* Added for centering the icon */
                justify-content: center;
                /* Added for centering the icon */
            }

            .floating-button button:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }

            .floating-button i {
                font-size: 2rem;
                /* Adjust icon size */
            }
        </style>

    </div>

    <script>
        function filterProducts(category) {
            const products = document.getElementsByClassName('product-item');

            Array.from(products).forEach(product => {
                if (category === 'all' || product.dataset.category === category) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        function openAddProductModal() {
            const modal = new bootstrap.Modal(document.getElementById('addProductModal'));
            modal.show();
        }

        function openEditProductModal(product) {
            console.log(product);
            const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
            document.getElementById('edit_product_id').value = product.product_id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_category').value = product.category;
            document.getElementById('edit_price').value = product.price;
            const currentImageDiv = document.getElementById('currentImage');
            const imageNameSpan = document.getElementById('imageName');

            if (product.image && product.image !== '') {
                currentImageDiv.style.display = 'block';
                imageNameSpan.textContent = product.image;
            } else {
                currentImageDiv.style.display = 'none';
            }

            modal.show();
        }
    </script>
@endsection
