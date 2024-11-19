@extends('layouts.app')
@section('title', $post->slug)

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-black" href="{{ route('posts.index') }}">Post</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->slug }}</li>
        </ol>
    </nav>

    <p><strong>ManyPost.com</strong> | {{ $post->created_at }}</p>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-3 w-25">Back</a>
    <img src="{{ asset('/storage/posts/' . $post->image) }}" class="card-img-top img-fluid mb-3" alt="{{ $post->title }}">
    <h1 class="fw-bold">{{ $post->title }}</h1>

    <p>Published at {{ $post->created_at->diffForHumans() }}</p>

    <article>
        <p>{{ $post->contents }}</p>
    </article>

    <div class="card p-3 m-3">
        <h3 class="card-title fw-bold mb-3">Kolom Komentar</h3>
        @forelse ($post->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $comment->user->name }}</h5>
                    <p class="card-text">{{ $comment->contents }}</p>
                    <p class="card-text"><small class="text-muted">Published at
                            {{ $comment->created_at->diffForHumans() }}</small>
                    </p>
                </div>
            </div>
        @empty
            <p>No comments found.</p>
        @endforelse

        <div class="card">
            <form action="{{ route('comments.store', $post->code_post) }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="mb-3 p-3">
                    <textarea placeholder="comments something...." class="form-control mb-3 @error('contents') is-invalid @enderror"
                        id="contents" name="contents">{{ old('contents') }}</textarea>
                    @error('contents')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
