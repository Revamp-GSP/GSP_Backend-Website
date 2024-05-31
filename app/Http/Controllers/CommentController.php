<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        // Validasi input
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'comment_text' => 'required|string',
            'task_id' => 'nullable|exists:tasks,id',
        ]);
    
        // Ambil user yang sedang terautentikasi
        $user = Auth::user();
    
        // Buat komentar baru terkait dengan proyek dan (opsional) tugas
        $comment = new Comment([
            'comment_text' => $request->comment_text,
            'user_id' => $user->id, // Menambahkan user_id dari user yang sedang terautentikasi
        ]);
    
        // Simpan komentar dengan menyimpannya ke model proyek atau tugas yang sesuai
        $project = \App\Models\Project::find($request->project_id);
        $project->comments()->save($comment);
    
        // Jika task_id disertakan dalam permintaan, simpan komentar ke model tugas yang sesuai juga
        if ($request->has('task_id')) {
            $task = \App\Models\Task::find($request->task_id);
            $task->comments()->save($comment);
        }
    
        // Response sukses
        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
    }

}
