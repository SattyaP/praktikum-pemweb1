@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h2 class="mb-4">Latest Posts</h2>

    <div class="row">
        @forelse ($posts as $post)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">{{ $post->title }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                        <p class="text-secondary">Tanggal Dibuat {{ $post->created_at }}</p>
                        <a href="{{ route('blogs.show', $post->id) }}" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No posts found.</p>
            </div>
        @endforelse
    </div>

    {{ $posts->links('pagination::bootstrap-5') }}
@endsection
