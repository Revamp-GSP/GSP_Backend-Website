<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('role', 'like', "%$search%");
            });
        }

        $users = $query->orderBy('id')->paginate(10);

        return view('users.indexusers', compact('users'));
    }

    public function create()
    {
        return view('users.createusers');
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:3',
            'is_admin' => 'required|boolean',
        ]);

        // Store the user
        $userData = $request->all();
        $userData['password'] = bcrypt($request->password);
        $userData['email_verified_at'] = Carbon::now();
        User::create($userData);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.editusers', compact('user'));
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->is_admin = $request->input('is_admin');
    $user->role = $request->input('role');

    // Check if the "Change Password" checkbox is checked and the new password is provided
    if ($request->has('change_password') && $request->filled('password')) {
        // Update the password if the checkbox is checked and a new password is provided
        $user->password = Hash::make($request->input('password'));
    }
    $user->save();
    return redirect()->route('users.index')
    ->with('success', 'User updated successfully.');}
    public function destroy($id)
    {
        // Delete the user
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
