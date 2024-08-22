<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskCreatedNotification;
use App\Notifications\TaskUpdatedNotification;
use App\Notifications\TaskDeletedNotification;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'project_id' => 'required|integer',
            'program_kegiatan' => 'required|string',
            'plan_date_start' => 'required|date',
            'plan_date_end' => 'required|date',
            'pic' => 'required|string',
            'divisi_terkait' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        // Simpan data baru ke dalam tabel Task
        $task = new Task();
        $task->project_id = $request->project_id;
        $task->program_kegiatan = $request->program_kegiatan;
        $task->plan_date_start = $request->plan_date_start;
        $task->plan_date_end = $request->plan_date_end;
        $task->pic = $request->pic;
        $task->divisi_terkait = $request->divisi_terkait;
        $task->keterangan = $request->keterangan;

        // Handle unggah file jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/files', $filename);
            $task->dokumen_output = $filename;
        }

        // Simpan ke dalam database
        $task->save();
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new TaskCreatedNotification($task));
        }

        // Redirect atau kirim respons sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Task berhasil ditambahkan.');
    }
    public function getTasks(Request $request)
    {
        $index = $request->index; // Ambil indeks task dari permintaan

        // Ambil data tugas dari database berdasarkan indeks atau sesuai kebutuhan
        $tasks = Task::where('index', $index)->get();

        // Kembalikan tampilan tabel tugas dalam bentuk HTML
        return view('tasks.table', ['tasks' => $tasks])->render();
    }

}
