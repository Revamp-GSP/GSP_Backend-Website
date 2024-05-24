<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Validator;

class UsersAPIController extends Controller
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

        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'is_admin' => 'required|boolean',        
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }
        // Store the user
        $userData = $request->all();
        $userData['password'] = bcrypt($request->password);
        $userData['email_verified_at'] = Carbon::now();
        User::create($userData);

        return response()->json(['message' => 'User created successfully.'], 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'is_admin' => 'required|boolean',        
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        // Update the user
        $user = User::findOrFail($id);
        $userData = $request->all();
        if ($request->has('password')) {
            $userData['password'] = bcrypt($request->password);
        }
        $user->update($userData);

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function destroy($id)
    {
        // Delete the user
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }
}
