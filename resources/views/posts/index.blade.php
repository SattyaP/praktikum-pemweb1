@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="mb-4 d-flex gap-5">
        <div class="d-flex flex-column">
            <div class="latest-post row mb-5">
                <h2 class="mb-3 fw-bold">Latest Posts</h2>
                @forelse ($posts as $post)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card hover-effect h-100">
                            <a href="{{ route('posts.show', $post->code_post) }}" class="card-body text-decoration-none">
                                <img src="{{ asset('/storage/posts/' . $post->image) }}" class="card-img-top mb-3"
                                    alt="{{ $post->title }}">
                                <h3 class="card-title fw-bold">{!! Str::limit($post->title, 45, '...') !!}</h3>
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
                <h2 class="fw-bold mb-3">All Posts</h2>
                @forelse ($allPosts as $post)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card hover-effect h-100">
                            <a href="{{ route('posts.show', $post->code_post) }}" class="card-body text-decoration-none">
                                <img src="{{ asset('/storage/posts/' . $post->image) }}" class="card-img-top mb-3"
                                    alt="{{ $post->title }}">
                                <h3 class="card-title fw-bold">{!! Str::limit($post->title, 45, '...') !!}</h3>
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
        </div>
        <div class="recentpost_section">
            <h2 class="mb-3 text-center fw-bold">RecentPost</h2>
            <ul class="list-unstyled">
                @forelse ($posts as $post)
                    <li class="mb-2"><a class="text-decoration-none text-black text-decoration-underline"
                            href="{{ '/posts/' . $post->code_post }}">{{ $post->title }}</a></li>
                @empty
                    <li>No Recent Post</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
