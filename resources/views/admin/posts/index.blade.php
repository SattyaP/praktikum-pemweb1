@extends('admin.layouts.app')

@section('title', 'Posts')
@section('title-content', 'Posts')

@section('content')
    <a class="btn btn-primary mb-3" href="{{ route('admin.posts.create') }}">Tambah Data</a>
    <table class="table">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Content</th>
                <th>Published At</th>
                <th>Author</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($collections as $collection)
                <tr>
                    <td>{{ $collection->id }}</td>
                    <td><img src="{{ asset('/storage/posts/' . $collection->image) }}" class="rounded" style="width: 150px">
                    </td>
                    <td>{{ $collection->title }}</td>
                    <td>{{ $collection->contents }}</td>
                    <td>{{ $collection->created_at->diffForHumans() }}</td>
                    <td>{{ $collection->use }}</td>
                    <td>
                        @if ($collection->categories)
                            @foreach ($collection->categories as $categories)
                                <span class="badge bg-primary">{{ $categories->name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.posts.edit', $collection) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.posts.destroy', $collection) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No posts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
