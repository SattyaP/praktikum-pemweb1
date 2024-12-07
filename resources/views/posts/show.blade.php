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
    <img src="{{ asset('/storage/posts/' . $post->image) }}" class="card-img-top img-fluid mb-3 w-75 rounded    " alt="{{ $post->title }}">
    <h1 class="fw-bold">{{ $post->title }}</h1>

    <div class="d-flex gap-3 align-items-center text-center">
        <div class="form-group">
            <a href="{{ route('like', $post->code_post) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="black"
                        d="M5 9v12H1V9zm4 12a2 2 0 0 1-2-2V9c0-.55.22-1.05.59-1.41L14.17 1l1.06 1.06c.27.27.44.64.44 1.05l-.03.32L14.69 8H21a2 2 0 0 1 2 2v2c0 .26-.05.5-.14.73l-3.02 7.05C19.54 20.5 18.83 21 18 21zm0-2h9.03L21 12v-2h-8.79l1.13-5.32L9 9.03z" />
                </svg>
            </a>

            <p>{{ $totalLikes }}</p>
        </div>
        <div class="form-group">
            <a href="{{ route('dislike', $post->code_post) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                    <path fill="black"
                        d="M19 15V3h4v12zM15 3a2 2 0 0 1 2 2v10c0 .55-.22 1.05-.59 1.41L9.83 23l-1.06-1.06c-.27-.27-.44-.64-.44-1.06l.03-.31l.95-4.57H3a2 2 0 0 1-2-2v-2c0-.26.05-.5.14-.73l3.02-7.05C4.46 3.5 5.17 3 6 3zm0 2H5.97L3 12v2h8.78l-1.13 5.32L15 14.97z" />
                </svg>
            </a>

            <p>{{ $totalDislikes }}</p>
        </div>
    </div>

    <p>Published at {{ $post->created_at->diffForHumans() }}</p>
    <p>Author by <strong>{{ $post->postCategories->first()->user->name}}</strong></p>

    <article>
        <p>{{ $post->contents }}</p>
    </article>

    <div class="card p-3 m-3">
        <h3 class="card-title fw-bold mb-3">Kolom Komentar</h3>
        @forelse ($post->comments as $comment)
            @if ($comment->scopePending($comment) && $comment->status !== 'rejected')
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $comment->user->name }}</h5>
                        <p class="card-text">{{ $comment->contents }}</p>
                        <p class="card-text"><small class="text-muted">Published
                                at{{ $comment->created_at->diffForHumans() }}</small></p>
                        @if (auth()->user()->id === $post->postCategories[0]->user_id)
                            <p class="card-text"><small class="text-muted">{{ $comment->status }}</small></p>
                        @endif
                    </div>
                    @if (auth()->user()->id === $post->postCategories[0]->user_id)
                        <div class="card-footer d-flex gap-3">
                            @if (!($comment->status === 'approved'))
                                <form action="{{ route('comments.approve', $comment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Approve</button>
                                </form>
                            @endif

                            @if (!($comment->status === 'approved'))
                                <form action="{{ route('comments.reject', $comment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
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
