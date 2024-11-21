@extends('admin.layouts.app')

@section('title', 'Show Posts')

@section('content')
    <h2 class="fw-bold mb-3">{{ $post->code_post }}</h2>
    <img src="{{ asset('/storage/posts/' . $post->image) }}" class="rounded img-fluid" style="width: 150px">

    <div class="mb-3">
        <label for="image" class="form-label">Thumbnail</label>
        <input disabled type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
            value="{{ old('image') }}">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input disabled type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
            value="{{ $post->title }}">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="contents" class="form-label">Content</label>
        <textarea disabled class="form-control @error('contents') is-invalid @enderror" id="contents" name="contents">{{ old('contents') }}</textarea>
        @error('contents')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label
            ">Category</label>
        <select disabled class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id[]"
            multiple>
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
    <a class="btn btn-secondary" href="{{ route('admin.posts.index') }}">Back</a>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('contents').value = `{{ $post->contents }}`;
        });
    </script>
@endsection
