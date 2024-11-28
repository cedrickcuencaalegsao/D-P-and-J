@extends('Layout.app')
@section('title', 'Dashboard')
@include('Components.NaBar.navbar')
@section('content')
    <h1>Dashboard</h1>
    <div>
        <h2>counts</h2>
        <div>
            <h3>User</h3>
            <p>{{ $data['usersCount'] }}</p>
        </div>
    </div>
    <div>
        <h2>Products</h2>
        <div>
            @forelse($data['products'] as $products)
                <div>
                    <p>{{ $products['name'] }}</p>
                    <p>{{ $products['price'] }}</p>
                </div>
            @empty
                <p>No Products found.</p>
            @endforelse
        </div>
    </div>
@endsection
