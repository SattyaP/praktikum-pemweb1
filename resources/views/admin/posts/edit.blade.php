@extends('admin.layouts.app')

@section('title', 'Edit Posts')

@section('content')
    <h2 class="fw-bold mb-3">Edit Post</h2>
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <img src="{{ asset('/storage/posts/' . $post->image) }}" class="rounded" style="width: 150px">

        <div class="mb-3">
            <label for="image" class="form-label">Thumbnail</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                value="{{ old('image') }}">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ $post->title }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="contents" class="form-label">Content</label>
            <textarea class="form-control @error('contents') is-invalid @enderror" id="contents" name="contents">{{ old('contents') }}</textarea>
            @error('contents')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label
            ">Category</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id[]" multiple>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->categories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class="btn btn-secondary" href="{{ route('admin.posts.index') }}">Back</a>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('contents').value = `{{ $post->contents }}`;
        });
    </script>
@endsection
