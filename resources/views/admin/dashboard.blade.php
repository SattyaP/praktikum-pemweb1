@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('title-content', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Posts</h5>
                    <p class="card-text">Total Posts: {{ $totalPost }}</p>
                </div>
            </div>
        </div>
        @if (Auth::user()->role == 'admin')
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text">Total Categories: {{ $totalCategories }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">Total Users: {{ $users }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
