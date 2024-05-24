@extends('layouts.app')

@section('content')
<div class="container" id="custom-container">
    <h2>Edit Pelanggan</h2>
    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_pelanggan">ID Pelanggan:</label>
            <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" value="{{ $customer->id_pelanggan }}" required>
        </div>
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ $customer->nama_pelanggan }}" required>
        </div>
        <div class="form-group">
            <label for="sebutan">Sebutan:</label>
            <input type="text" class="form-control" id="sebutan" name="sebutan" value="{{ $customer->sebutan }}" required>
        </div>
        <div class="form-group">
            <label for="created_by">Created By:</label>
            <input type="text" class="form-control" id="created_by" name="created_by" value="{{ $customer->created_by }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

<link href="{{ asset('css/services.css') }}" rel="stylesheet">
