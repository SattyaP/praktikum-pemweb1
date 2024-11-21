@extends('admin.layouts.app')

@section('title', 'Posts')
@section('title-content', 'Posts')

@section('content')
    <a class="btn btn-primary mb-3" href="{{ route('admin.posts.create') }}">Tambah Data</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @include('admin.partials.error')

    <table class="table table-responsive">
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
                    <td>{{ auth()->user()->name }}</td>
                    <td>
                        @if ($collection->categories)
                            @foreach ($collection->categories as $categories)
                                <span class="badge bg-primary">{{ $categories->name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.posts.edit', $collection->id) }}" class="btn btn-sm btn-warning"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <svg fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2">
                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path
                                            d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                    </svg>
                                </svg></a>
                            <a href="{{ route('admin.posts.show', $collection->id) }}" class="btn btn-sm btn-info"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="white"
                                        d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                                </svg></a>
                            <form onsubmit="return confirm('Are you sure you want to delete this?')"
                                action="{{ route('admin.posts.destroy', $collection->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="20" height="20" viewBox="0 0 24 24">
                                        <path fill="white"
                                            d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                                    </svg></button>
                            </form>
                        </div>
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
