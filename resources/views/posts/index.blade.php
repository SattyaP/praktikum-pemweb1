@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="latest-posts mb-4 row p-0">
        <h2 class="mb-3">Latest Posts</h2>
        @forelse ($posts as $post)
            <div class="col-4 mb-3">
                <div class="card hover-effect h-100">
                    <a href="{{ route('posts.show', $post->code_post) }}" class="card-body text-decoration-none">
                        <img src="{{ asset('/storage/posts/' . $post->image) }}" class="card-img-top mb-3" alt="{{ $post->title }}">
                        <h3 class="card-title fw-bold">{{ $post->title }}</h3>
                        <p class="card-text">{!! Str::limit($post->contents, 200, '[...]') !!}</p>
                        <p class="card-text"><small class="text-muted">Published at
                                {{ $post->created_at->diffForHumans() }}</small>
                        </p>

                        @forelse ($post->categories as $cat)
                            <span class="badge text-bg-primary">{{ $cat->name }}</span>
                        @empty
                            <span class="badge bg-primary">No Category</span>
                        @endforelse
                    </a>
                </div>
            </div>
        @empty
            <p>No posts found.</p>
        @endforelse
    </div>

    <div class="all-posts p-0 row">
        <h2>All Posts</h2>
        @forelse ($allPosts as $post)
            <div class="col-4 mb-3">
                <div class="card hover-effect h-100">
                    <a href="{{ route('posts.show', $post->code_post) }}" class="card-body text-decoration-none">
                        <img src="{{ asset('/storage/posts/' . $post->image) }}" class="card-img-top mb-3" alt="{{ $post->title }}">
                        <h3 class="card-title fw-bold mb-3">{{ $post->title }}</h3>
                        <p class="card-text">{{ $post->contents }}</p>
                        <p class="card-text"><small class="text-muted">Published at
                                {{ $post->created_at->diffForHumans() }}</small>
                        </p>
                        @forelse ($post->categories as $cat)
                            <span class="badge text-bg-primary">{{ $cat->name }}</span>
                        @empty
                            <span class="badge bg-primary">No Category</span>
                        @endforelse
                    </a>
                </div>
            </div>
        @empty
            <p>No posts found.</p>
        @endforelse
    </div>
@endsection
