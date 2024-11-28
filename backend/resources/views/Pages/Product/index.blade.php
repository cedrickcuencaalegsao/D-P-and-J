@extends('Layout.app')
@section('title', 'Products')
@include('Components.NaBar.navbar')
@section('content')
    <h1>Products</h1>
    <div>
        @forelse ($data as $products)
            <h3>{{ $products['name'] }}</h3>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
@endsection
