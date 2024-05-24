<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create()
    {
        return view('comments.create');
    }

    public function store(Request $request)
    {
        // Validasi data masukan
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string|max:255',
        ]);

        // Simpan komentar ke database
        Comment::create($request->all());

        // Redirect ke halaman sebelumnya
        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}
