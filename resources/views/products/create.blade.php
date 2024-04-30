@extends('layouts.app')

@section('content')
<div class="container" id="custom-container2">
    <h2>Add New Product</h2>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="produk">Product:</label>
            <input type="text" class="form-control" id="produk" name="produk" >
        </div>
        <div class="form-group">
            <label for="deskripsi">Description:</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
        </div>
        <div class="form-group">
            <label for="id_service">Service ID:</label>
            <input type="text" class="form-control" id="id_service" name="id_service" required>
                
        </div>
        <div class="form-group">
            <label for="nama_service">Nama Service:</label>
            <input type="text" class="form-control" id="nama_service" name="nama_service" required>
        </div>
        <div class="form-group">
            <label for="created_by">Created By:</label>
            <input type="text" class="form-control" id="created_by" name="created_by" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

<link href="{{ asset('css/services.css') }}" rel="stylesheet">
