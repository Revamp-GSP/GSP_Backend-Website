@extends('layouts.app')

@section('content')
<div class="container" id="custom-container2">
    <h2>Add New User</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="is_admin">Is Admin:</label>
            <div class="radio-buttons">
                <input type="radio" id="is_admin_yes" name="is_admin" value="1">
                <label for="is_admin_yes">Yes</label>
                <input type="radio" id="is_admin_no" name="is_admin" value="0" checked>
                <label for="is_admin_no">No</label>
            </div>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" id="role" name="role" required>
                <option value="Admin">Admin</option>
                <option value="Business Development">Business Development</option>
                <option value="Office Business Administration">Office Business Administration</option>
                <option value="IT Service Administration">IT Service Administration</option>
                <option value="Direksi">Direksi</option>
                <option value="Manager Keuangan">Manager Keuangan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

<link href="{{ asset('css/users.css') }}" rel="stylesheet">
