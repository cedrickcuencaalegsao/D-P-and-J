@extends('Layout.app')
@section('title', 'Category')
@include('Components.NaBar.navbar')
@section('content')
    <h1>Category</h1>
    @forelse ($data as $category)
        <h3>{{ $category['name'] }}</h3>

    @empty
        <p>No Category Found.</p>
    @endforelse
@endsection
