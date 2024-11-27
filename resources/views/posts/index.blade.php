@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-black"href="{{ route('posts.index') }}">Post</a></li>
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>

    <form method="GET" action="{{ route('search') }}" class="form-group d-flex gap-3 py-2 mb-3">
        <input class="form-control form-control-lg" id="search-form" name="q" placeholder="Cari Sesuatu...">
        <button class="btn btn-lg btn-primary">Search</button>
    </form>
    <div class="mb-4 d-flex justify-content-between gap-5">
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
