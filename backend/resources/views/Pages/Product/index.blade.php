@extends('Layout.app')
@section('title', 'Products')
@include('Components.NaBar.navbar')
@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
            @forelse ($data as $product)
                <div class="col">
                    <x-cards.card :title="$product['name']" :description="$product['description'] ?? ''" :image="$product['image'] ?? ''" :price="$product['price'] ?? 0" />
                </div>
            @empty
                <div class="col">
                    <p>No products found.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
