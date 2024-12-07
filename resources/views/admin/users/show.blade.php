@extends('admin.layouts.app')

@section('title', 'Show User')

@section('content')
    <h2 class="fw-bold mb-3">Show User</h2>

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" disabled readonly>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" disabled readonly>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <input type="text" class="form-control" id="role" name="role" value="{{ $user->role }}" disabled readonly>
    </div>

    <div class="mb-3">
        <label for="created_at" class="form-label">Created At</label>
        <input type="text" class="form-control" id="created_at" disabled name="created_at"
            value="{{ $user->created_at->diffForHumans() }}" readonly>
    </div>

    <a class="btn btn-warning" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
    <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Back</a>
@endsection

