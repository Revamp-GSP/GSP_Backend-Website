@extends('layouts.app')

@section('content')
<div class="container" id="custom-container">
    <!-- Display any success message here -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and filter form -->
    <div class="search-create-wrapper">
        <a href="{{ route('users.create') }}" class="btn btn-primary" id="btnsw">Add New User</a>

        <form action="{{ route('users.index') }}" method="GET" style="margin-bottom:5px;">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
            <button type="submit" id="btnsw">Search</button>
        </form>
    </div>

    <!-- Users table -->
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Is Admin</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $baseNumber = ($users->currentPage() - 1) * $users->perPage() + 1;
            @endphp
            @foreach ($users as $user)
                <tr>
                    <td>{{ $baseNumber + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination links -->
    <div class="pagination">
        @if ($users->onFirstPage())
            <span>&laquo; Previous</span>
        @else
            <a href="{{ $users->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
        @endif

        @if ($users->lastPage() > 1)
            @for ($i = 1; $i <= $users->lastPage(); $i++)
                @if ($i == $users->currentPage())
                    <span id="page-{{ $i }}" class="active">{{ $i }}</span>
                @else
                    <a id="page-{{ $i }}" href="{{ $users->url($i) }}">{{ $i }}</a>
                @endif
            @endfor
        @endif

        @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" rel="next">Next &raquo;</a>
        @else
            <span>Next &raquo;</span>
        @endif
    </div>

@endsection

<link href="{{ asset('css/users.css') }}" rel="stylesheet">
