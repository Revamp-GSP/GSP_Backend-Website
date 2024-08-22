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
        <a href="{{ route('products.create') }}" class="btn btn-primary" id="btnsw">Add New Service</a>

        <form action="{{ route('products.index') }}" method="GET" style="margin-bottom:5px;">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
            <button type="submit" id="btnsw">Search</button>
        </form>
    </div>

    <!-- Products table -->
    <div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Service ID</th>
                <th>Nama Service</th>
                <th>Description</th>
                <th>id</th>
                <th>date_added</th>
                <th>date_updated</th>
                <th>created_by</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $baseNumber = ($products->currentPage() - 1) * $products->perPage() + 1;
            @endphp
            @foreach ($products as $product)
                <tr>
                <td>{{ $baseNumber + $loop->index }}</td>
                    <td>{{ $product->produk }}</td>
                    <td>{{ $product->id_service }}</td>
                    <td>{{ $product->nama_service }}</td>
                    <td>{{ $product->deskripsi }}</td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->date_added }}</td>
                    <td>{{ $product->date_updated }}</td>
                    <td>{{ $product->created_by }}</td>


                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <!-- Pagination links -->
    <div class="pagination">
        @if ($products->onFirstPage())
            <span>&laquo; Previous</span>
        @else
            <a href="{{ $products->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
        @endif

        @if ($products->lastPage() > 1)
            @for ($i = 1; $i <= $products->lastPage(); $i++)
                @if ($i == $products->currentPage())
                    <span id="page-{{ $i }}" class="active">{{ $i }}</span>
                @else
                    <a id="page-{{ $i }}" href="{{ $products->url($i) }}">{{ $i }}</a>
                @endif
            @endfor
        @endif

        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" rel="next">Next &raquo;</a>
        @else
            <span>Next &raquo;</span>
        @endif
    </div>
@endsection

<link href="{{ asset('css/services.css') }}" rel="stylesheet">
