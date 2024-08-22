<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Notifications\TaskCreatedNotification;
use App\Notifications\TaskUpdatedNotification;
use App\Notifications\TaskDeletedNotification;
use Validator;

class TaskAPIController extends Controller
{
    // Metode untuk menampilkan semua task
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    // Metode untuk menyimpan task baru
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'program_kegiatan' => 'required|string',
            'plan_date_start' => 'required|date',
            'plan_date_end' => 'required|date',
            'pic' => 'required|string',
            'divisi_terkait' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        $task = Task::create($request->all());
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new TaskCreatedNotification($task));
        }

        return response()->json($task, 201);
    }

    // Metode untuk menampilkan detail task berdasarkan ID
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    // Metode untuk memperbarui task berdasarkan ID
    public function update(Request $request, $nama_pekerjaan, $task_id)
    {
        // Mencari task berdasarkan ID dan nama pekerjaan
        $task = Task::where('id', $task_id)
                    ->whereHas('project', function ($query) use ($nama_pekerjaan) {
                        $query->where('nama_pekerjaan', $nama_pekerjaan);
                    })
                    ->firstOrFail();
        $originalTask = $task->replicate(); // Simpan nilai asli proyek sebelum pembaruan
        // Mengupdate atribut-atribut task dengan data yang dikirimkan melalui request
        $task->update($request->all());
        $changes = [];
        foreach ($request->all() as $key => $value) {
            if ($originalTask->$key != $value && $key !== '_token' && $key !== '_method') {
                $changes[$key] = [
                    'old' => $originalTask->$key,
                    'new' => $value,
                ];
            }
        }

        // Kirim notifikasi hanya jika ada perubahan
        if (!empty($changes)) {
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new TaskUpdatedNotification($task, $changes));
            }
        }
        // Mengembalikan respons JSON dengan task yang telah diperbarui
        return response()->json($task, 200);
    }

    // Metode untuk menghapus task berdasarkan ID
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
    public function getTasksByNamaPekerjaan($nama_pekerjaan)
    {
        // Dapatkan ID proyek berdasarkan nama pekerjaan
        $projectId = Project::where('nama_pekerjaan', $nama_pekerjaan)->value('id');

        // Ambil tugas dari database berdasarkan ID proyek
        $tasks = Task::where('project_id', $projectId)->get();

        // Mengembalikan tugas dalam format JSON
        return response()->json($tasks);
    }
    public function storeTask(Request $request, $nama_pekerjaan)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'program_kegiatan' => 'required|string',
            'plan_date_start' => 'required|date',
            'plan_date_end' => 'required|date',
            'actual_date_start' => 'required|date',
            'actual_date_end' => 'required|date',
            'pic' => 'required|string',
            'divisi_terkait' => 'required|string',
            'keterangan' => 'sometimes|string',
            'dokumen_output' => 'sometimes|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $projectId = Project::where('nama_pekerjaan', $nama_pekerjaan)->value('id');

        // Buat tugas baru
        $task = new Task();
        $task->project_id = $projectId;
        $task->program_kegiatan = $request->program_kegiatan;
        $task->plan_date_start = $request->plan_date_start;
        $task->plan_date_end = $request->plan_date_end;
        $task->actual_date_start = $request->actual_date_start;
        $task->actual_date_end = $request->actual_date_end;
        $task->nama_task = $request->nama_task;
        $task->pic = $request->pic;
        $task->divisi_terkait = $request->divisi_terkait;
        $task->keterangan = $request->keterangan;

        // Handle unggah file jika ada
        if ($request->hasFile('dokumen_output')) {
            $file = $request->file('dokumen_output');
            $originalFilename = $file->getClientOriginalName();
            $file->move(public_path('files'), $originalFilename);
            $task->dokumen_output = $originalFilename;
        }

        $task->save();

        // Mengirim notifikasi ke pengguna
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new TaskCreatedNotification($task));
        }

        // Mengembalikan respons JSON
        return redirect()->route('projects.show', ['nama_pekerjaan' => $request->nama_pekerjaan])
        ->with('success', 'Task berhasil ditambahkan.');
        }

    public function updateTask(Request $request, $nama_pekerjaan, $task_id)
    {
        // Validasi input menggunakan Validator
        $validator = Validator::make($request->all(), [
            'program_kegiatan' => 'required|string',
            'plan_date_start' => 'required|date',
            'plan_date_end' => 'required|date',
            'actual_date_start' => 'required|date',
            'actual_date_end' => 'required|date',
            'pic' => 'required|string',
            'divisi_terkait' => 'required|string',
            'keterangan' => 'sometimes|string',
        ]);
    
        // Jika validasi gagal, kembalikan respon JSON dengan pesan kesalahan
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }
    
        try {
            // Temukan task berdasarkan ID
            $task = Task::findOrFail($task_id);
            $originalTask = $task->replicate(); // Simpan nilai asli task sebelum pembaruan
    
            // Update atribut-atribut task dengan data dari request
            $task->program_kegiatan = $request->program_kegiatan;
            $task->plan_date_start = $request->plan_date_start;
            $task->plan_date_end = $request->plan_date_end;
            $task->actual_date_start = $request->actual_date_start;
            $task->actual_date_end = $request->actual_date_end;
            $task->pic = $request->pic;
            $task->divisi_terkait = $request->divisi_terkait;
            $task->keterangan = $request->keterangan;
    
            // Simpan perubahan
            $task->save();
            
            $changes = [];
            foreach ($request->all() as $key => $value) {
                if ($originalTask->$key != $value && $key !== '_token' && $key !== '_method') {
                    $changes[$key] = [
                        'old' => $originalTask->$key,
                        'new' => $value,
                    ];
                }
            }
    
            // Kirim notifikasi hanya jika ada perubahan
            if (!empty($changes)) {
                $users = User::all();
                foreach ($users as $user) {
                    $user->notify(new TaskUpdatedNotification($task, $changes));
                }
            }
    
            // Mengembalikan respons JSON sukses
            return redirect()->route('projects.show', ['nama_pekerjaan' => $nama_pekerjaan])
            ->with('success', 'Task berhasil diperbarui.');
            } catch (\Exception $e) {
            // Logging error detail
            \Log::error('Update task error: ' . $e->getMessage());
    
            // Jika task tidak ditemukan atau terjadi kesalahan lain
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui task. Pesan error: ' . $e->getMessage()], 500);
        }
    }
    
        public function deleteTask($nama_pekerjaan, $task_id)
        {
            try {
                // Temukan proyek berdasarkan nama pekerjaan
                $project = Project::where('nama_pekerjaan', $nama_pekerjaan)->firstOrFail();
        
                // Temukan task berdasarkan ID dan ID proyek
                $task = Task::where('id', $task_id)
                    ->where('project_id', $project->id)
                    ->firstOrFail();
        
                // Hapus file dokumen output jika ada
                if ($task->dokumen_output) {
                    $filePath = public_path($task->dokumen_output);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
                // Hapus data task
                $task->delete();
        
                // Kirim notifikasi ke semua pengguna
                $users = User::all();
                foreach ($users as $user) {
                    $user->notify(new TaskDeletedNotification($task));
                }
        
                // Kembalikan respons sukses
                return response()->json([
                    'success' => true,
                    'message' => 'Task berhasil dihapus.'
                ]);
            } catch (\Exception $e) {
                // Jika task tidak ditemukan atau terjadi kesalahan lain
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus task. Pesan error: ' . $e->getMessage()
                ], 404);
            }
        }
}
