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
        <a href="{{ route('customers.create') }}" class="btn btn-primary" id="btnsw">Add New Customer</a>

        <form action="{{ route('customers.index') }}" method="GET" style="margin-bottom:5px;">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
            <button type="submit" id="btnsw">Search</button>
        </form>
    </div>

    <!-- Customers table -->
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Sebutan</th>
                <th>Date Added</th>
                <th>Date Updated</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $baseNumber = ($customers->currentPage() - 1) * $customers->perPage() + 1;
            @endphp
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $baseNumber + $loop->index }}</td>
                    <td>{{ $customer->id_pelanggan }}</td>
                    <td>{{ $customer->nama_pelanggan }}</td>
                    <td>{{ $customer->sebutan }}</td>
                    <td>{{ $customer->date_added }}</td>
                    <td>{{ $customer->date_updated }}</td>
                    <td>{{ $customer->created_by }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
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
    @if ($customers->onFirstPage())
        <span>&laquo; Previous</span>
    @else
        <a href="{{ $customers->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
    @endif

    @if ($customers->lastPage() > 1)
        @for ($i = 1; $i <= $customers->lastPage(); $i++)
            @if ($i == $customers->currentPage())
                <span id="page-{{ $i }}" class="active">{{ $i }}</span>
            @else
                <a id="page-{{ $i }}" href="{{ $customers->url($i) }}">{{ $i }}</a>
            @endif
        @endfor
    @endif

    @if ($customers->hasMorePages())
        <a href="{{ $customers->nextPageUrl() }}" rel="next">Next &raquo;</a>
    @else
        <span>Next &raquo;</span>
    @endif
</div>


</div>
@endsection

<link href="{{ asset('css/customers.css') }}" rel="stylesheet">
