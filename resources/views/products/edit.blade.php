@extends('layouts.app')

@section('content')
    <div class="container" id="custom-container" style="background:transparent;">
    <h2>Edit Services</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="produk">Product:</label>
            <input type="text" class="form-control" id="produk" name="produk" value="{{ $product->produk }}" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Description:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi">{{ $product->deskripsi }}</textarea>
        </div>
        <div class="form-group">
            <label for="id_service">Service ID:</label>
            <input type="text" class="form-control" id="id_service" name="id_service" value="{{ $product->id_service }}" required>
        </div>
        <div class="form-group">
            <label for="id_service">Created By:</label>
            <input type="text" class="form-control" id="created_by" name="created_by" value="{{ $product->created_by }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

<link href="{{ asset('css/services.css') }}" rel="stylesheet">
