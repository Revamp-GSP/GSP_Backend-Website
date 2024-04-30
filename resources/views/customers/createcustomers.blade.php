@extends('layouts.app')

@section('content')
<div class="container" id="custom-container2">
    <h2>Add New Pelanggan</h2>
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_pelanggan">ID Customer:</label>
            <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" required>
        </div>
        <div class="form-group">
            <label for="nama_pelanggan">Nama Customer:</label>
            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
        </div>
        <div class="form-group">
            <label for="sebutan">Sebutan:</label>
            <input type="text" class="form-control" id="sebutan" name="sebutan" required>
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
