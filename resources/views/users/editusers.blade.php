@extends('layouts.app')

@section('content')
<div class="container" id="custom-container">
    <h2>Edit User</h2>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <!-- Is Admin Field -->
        <div class="form-group">
            <label for="is_admin">Is Admin:</label>
            <select class="form-control" id="is_admin" name="is_admin">
                <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <!-- Role Field -->
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" id="role" name="role">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="business_development" {{ $user->role == 'business_development' ? 'selected' : '' }}>Business Development</option>
                <option value="office_business_administration" {{ $user->role == 'office_business_administration' ? 'selected' : '' }}>Office Business Administration</option>
                <option value="it_service_administration" {{ $user->role == 'it_service_administration' ? 'selected' : '' }}>IT Service Administration</option>
                <option value="direksi" {{ $user->role == 'direksi' ? 'selected' : '' }}>Direksi</option>
                <option value="manager_keuangan" {{ $user->role == 'manager_keuangan' ? 'selected' : '' }}>Manager Keuangan</option>
            </select>
        </div>
        <div class="form-group">
    <label for="change_password">
        <input type="checkbox" id="change_password" name="change_password"> Change Password
    </label>
</div>

<!-- New Password Field (hidden by default) -->
<div class="form-group" id="new_password_field" style="display: none;">
    <label for="new_password">New Password:</label>
    <input type="password" class="form-control" id="password" name="password">
</div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#change_password').change(function(){
            if($(this).is(":checked")) {
                $('#new_password_field').show();
            } else {
                $('#new_password_field').hide();
            }
        });
    });
</script>
@endsection

<link href="{{ asset('css/users.css') }}" rel="stylesheet">
