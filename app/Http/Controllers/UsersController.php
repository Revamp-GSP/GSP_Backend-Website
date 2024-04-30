<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

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
            'password' => 'required|min:6',
            'is_admin' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
        // Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
        ]);

        // Update the user
        $user = User::findOrFail($id);
        $userData = $request->all();
        if ($request->has('password')) {
            $userData['password'] = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $user->image = $imagePath;
        }
        $user->update($userData);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }
    public function upload(Request $request)
    {
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $request->image->storeAs('images',$filename,'public');
            Auth()->user()->update(['image'=>$filename]);
        }
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the user
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
