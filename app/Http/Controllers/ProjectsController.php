<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\customers;
use App\Models\produk;
use App\Models\Task;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use App\Notifications\ProjectUpdatedNotification;
use App\Notifications\ProjectDeletedNotification;

use Validator;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        $totalProjects = Project::count();

        if ($request->has('date_range_start') && $request->has('date_range_end')) {
            $dateRangeStart = $request->date_range_start;
            $dateRangeEnd = $request->date_range_end;
    
            $query->whereBetween('plan_start_date', [$dateRangeStart, $dateRangeEnd])
                  ->orWhereBetween('plan_end_date', [$dateRangeStart, $dateRangeEnd])
                  ->orWhereBetween('actual_start_date', [$dateRangeStart, $dateRangeEnd])
                  ->orWhereBetween('actual_end_date', [$dateRangeStart, $dateRangeEnd]);
        }
    
        // Search by product name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%$search%")
                  ->orWhere('nama_service', 'like', "%$search%")
                  ->orWhere('nama_pekerjaan', 'like', "%$search%")
                  ->orWhere('nilai_pekerjaan_rkap', 'like', "%$search%")
                  ->orWhere('id', 'like', "%$search%")
                  ->orWhere('nilai_pekerjaan_rkap', 'like', "%$search%")
                  ->orWhere('nilai_pekerjaan_aktual', 'like', "%$search%")
                  ->orWhere('nilai_pekerjaan_kontrak_tahun_berjalan', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%")
                  ->orWhere('account_marketing', 'like', "%$search%")
                  ;
            });
        }
        $projects = $query->orderByRaw("
            CASE
                WHEN status = 'Selesai' THEN 1
                WHEN status = 'Pembayaran' THEN 2
                WHEN status = 'Implementasi' THEN 3
                WHEN status = 'Follow Up' THEN 4
                WHEN status = 'Postpone' THEN 5
                ELSE 6
            END
        ")->orderBy('id')->paginate(10);
            return view('projects.indexprojects', compact('projects'));
        }

    public function create()
    {
        $customers = customers::all();
        $produks = produk::all();
        return view('projects.createprojects', compact('customers', 'produks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes|exists:customers,id',
            'product_id' => 'sometimes|exists:produks,id',
            'status' => 'required',
            'nama_pelanggan' => 'required',
            'nama_service' => 'required',
            'nama_pekerjaan' => 'required',
            'nilai_pekerjaan_rkap' => 'required|numeric',
            'nilai_pekerjaan_aktual' => 'required|numeric',
            'nilai_pekerjaan_kontrak_tahun_berjalan' => 'required|numeric',
            'plan_start_date' => 'nullable|date',
            'plan_end_date' => 'nullable|date',
            'actual_start_date' => 'nullable|date',
            'actual_end_date' => 'nullable|date',
            'account_marketing' => 'required',
            'dirut' => 'nullable|string',
            'dirop' => 'nullable|string',
            'dirke' => 'nullable|string',
            'kskmr' => 'nullable|string',
            'ksham' => 'nullable|string',
            'msdmu' => 'nullable|string',
            'mkakt' => 'nullable|string',
            'mbilp' => 'nullable|string',
            'mppti' => 'nullable|string',
            'mopti' => 'nullable|string',
            'mbsar' => 'nullable|string',
            'msadb' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        

        $project = Project::create($request->all());
        $customer = customers::firstOrCreate(['nama_pelanggan' => $request->nama_pelanggan]);

        $produk = produk::firstOrCreate(['nama_service' => $request->nama_service]);

        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new ProjectCreatedNotification($project));
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $produks = Produk::all();
        $customers = Customers::all();
        $account_marketing = [
            'Administrator' => ['Ahmad Gunawan', 'Sugih Permana', 'Yana Nugraha'],
            'Busdev' => ['Admin Sales', 'Alia Almitra', 'Aufa Putra', 'Desiana Latief', 'Greyta Sarah', 'Hadi Mustofa', 'Harry Fitriana', 'Isma Soraya', 'Johanes B. Indra', 'Mulyana Santosa', 'Olley Mosye', 'Ramdani Apriansyah', 'Ryan Apriantho', 'Sarah Thoharhatunissa', 'Topan Permata', 'Winda Sundayani'],
            'Direksi' => ['Bayu Mahendra', 'Burhanuddin -', 'Ruly Fasri'],
            'Manager Keuangan' => ['Elsa Marina', 'Oki Satrya', 'Taufik Munandar'],
        ];
        
        // Mengelompokkan data account marketing berdasarkan label optgroup
        $grouped_account_marketing = collect($account_marketing)->map(function ($options, $label) {
            return [
                'label' => $label,
                'options' => $options,
            ];
        });
        return view('projects.editprojects', compact('project', 'produks', 'customers', 'grouped_account_marketing'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes|exists:customers,id',
            'product_id' => 'sometimes|exists:produks,id',
            'status' => 'required',
            'nama_pelanggan' => 'required',
            'nama_service' => 'required',
            'nama_pekerjaan' => 'required',
            'nilai_pekerjaan_rkap' => 'required|numeric',
            'nilai_pekerjaan_aktual' => 'required|numeric',
            'nilai_pekerjaan_kontrak_tahun_berjalan' => 'required|numeric',
            'plan_start_date' => 'nullable|date',
            'plan_end_date' => 'nullable|date',
            'actual_start_date' => 'nullable|date',
            'actual_end_date' => 'nullable|date',
            'account_marketing' => 'required',
            'dirut' => 'nullable|string',
            'dirop' => 'nullable|string',
            'dirke' => 'nullable|string',
            'kskmr' => 'nullable|string',
            'ksham' => 'nullable|string',
            'msdmu' => 'nullable|string',
            'mkakt' => 'nullable|string',
            'mbilp' => 'nullable|string',
            'mppti' => 'nullable|string',
            'mopti' => 'nullable|string',
            'mbsar' => 'nullable|string',
            'msadb' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $project = Project::findOrFail($id);
        $originalProject = $project->replicate(); // Simpan nilai asli proyek sebelum pembaruan
    
        $customer = customers::firstOrCreate(['nama_pelanggan' => $request->nama_pelanggan]);
        $produk = produk::firstOrCreate(['nama_service' => $request->nama_service]);
    
        $project->update($request->all());
    
        // Bandingkan data lama dan data baru
        // Bandingkan data lama dan data baru
        $changes = [];
        foreach ($request->all() as $key => $value) {
            if ($originalProject->$key != $value && $key !== '_token' && $key !== '_method') {
                $changes[$key] = [
                    'old' => $originalProject->$key,
                    'new' => $value,
                ];
            }
        }

        // Kirim notifikasi hanya jika ada perubahan
        if (!empty($changes)) {
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new ProjectUpdatedNotification($project, $changes));
            }
        }
        // Kirim notifikasi dengan detail perubahan
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new ProjectUpdatedNotification($project, $changes));
        }
    
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }
    
    public function destroy($id)
        {
            $project = Project::findOrFail($id); // Ambil project berdasarkan ID
            $project->delete(); // Hapus project

            // Kirim notifikasi kepada semua pengguna tentang penghapusan proyek
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new ProjectDeletedNotification($project->name));
            }

            return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
        }


    // Metode untuk menampilkan detail proyek
    public function show($nama_pekerjaan)
    {
        $project = Project::where('nama_pekerjaan', $nama_pekerjaan)->first();
        $comments = Comment::where('task_id', $project->id)->get();

        if (!$project) {
            abort(404);
        }

        // Dapatkan status proyek
        $currentStatus = $project->status;

        // Langkah-langkah statis atau berdasarkan status proyek
        $steps = [
            ['number' => 1, 'name' => 'Postpone', 'description' => 'Deskripsi Langkah 1'],
            ['number' => 2, 'name' => 'Follow Up', 'description' => 'Deskripsi Langkah 2'],
            ['number' => 3, 'name' => 'Implementasi', 'description' => 'Deskripsi Langkah 3'],
            ['number' => 4, 'name' => 'Pembayaran', 'description' => 'Deskripsi Langkah 4'],
            ['number' => 5, 'name' => 'Selesai', 'description' => 'Deskripsi Langkah 5'],
        ];

        // Daftar task statis
        $tasksStatic = [
            ['nama_task' => 'Permintaan Penawaran Harga User', 'deskripsi' => 'Deskripsi Task 1'],
            ['nama_task' => 'Pengiriman Penawaran Harga User', 'deskripsi' => 'Deskripsi Task 2'],
            ['nama_task' => 'Proses Pengadaan', 'deskripsi' => 'Deskripsi Task 3'],
            ['nama_task' => 'Surat Penunjukan Pelaksana Pekerjaan', 'deskripsi' => 'Deskripsi Task 3'],
            ['nama_task' => 'Pembuatan dan Penandatanganan PKS', 'deskripsi' => 'Deskripsi Task 3'],
            ['nama_task' => 'Persiapan Pekerjaan', 'deskripsi' => 'Deskripsi Task 3'],
            ['nama_task' => 'Pelaksanaan Pekerjaan', 'deskripsi' => 'Deskripsi Task 3'],
            ['nama_task' => 'BAPS/BAST/BAUK', 'deskripsi' => 'Deskripsi Task 3'],
            ['nama_task' => 'Invoice', 'deskripsi' => 'Deskripsi Task 3'],
            ['nama_task' => 'Payment', 'deskripsi' => 'Deskripsi Task 3'],
        ];

        $tasks = Task::where('project_id', $project->id)->get();

        return view('projects.showprojects', [
            'project' => $project,
            'steps' => $steps,
            'currentStatus' => $currentStatus,
            'tasksStatic' => $tasksStatic, // Tugas statis
            'tasks' => $tasks,
            'comments' => $comments
        ]);
    }

    // Metode untuk menyimpan task baru
    public function storeTask(Request $request, $nama_pekerjaan)
    {
        // Validasi input
        $request->validate([
            'program_kegiatan' => 'required|string',
            'plan_date_start' => 'required|date',
            'plan_date_end' => 'required|date',
            'actual_date_start' => 'required|date',
            'actual_date_end' => 'required|date',
            'dokumen_output' => 'nullable|file|mimes:pdf,doc,docx',
            'pic' => 'required|string',
            'divisi_terkait' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        $projectId = Project::where('nama_pekerjaan', $nama_pekerjaan)->value('id');

        // Buat tugas baru
        $task = new Task();
        $task->project_id = $projectId;
        $task->program_kegiatan = $request->program_kegiatan;
        $task->plan_date_start = $request->plan_date_start;
        $task->plan_date_end = $request->plan_date_end;
        $task->actual_date_start = $request->actual_date_start;
        $task->actual_date_end = $request->actual_date_end;
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

        // Redirect atau kirim respons sesuai kebutuhan Anda
        return redirect()->route('projects.show', ['nama_pekerjaan' => $request->nama_pekerjaan])
        ->with('success', 'Task berhasil ditambahkan.');    
    }
    public function getTasks(Request $request)
    {
        $index = $request->index; // Ambil indeks task dari permintaan

        // Ambil data tugas dari database berdasarkan indeks atau sesuai kebutuhan
        $tasks = Task::where('id', $index)->get();

        // Kembalikan tampilan tabel tugas dalam bentuk HTML
        return view('projects.showprojects', [
            'tasks' => $tasks, // Tugas untuk tampilan tabel
        ])->render();    
    }
    public function showTask($nama_pekerjaan, $task_id)
{
    try {
        // Temukan task berdasarkan ID dan nama pekerjaan
        $task = Task::where('id', $task_id)
                    ->whereHas('project', function ($query) use ($nama_pekerjaan) {
                        $query->where('nama_pekerjaan', $nama_pekerjaan);
                    })
                    ->firstOrFail();

        // Kembalikan respons dengan menampilkan halaman detail task
        return redirect()->route('projects.show', ['nama_pekerjaan' => $nama_pekerjaan])->with('success', 'Task berhasil diperbarui');
    } catch (\Exception $e) {
        // Jika task tidak ditemukan atau terjadi kesalahan lain
        return redirect()->route('projects.show', ['nama_pekerjaan' => $nama_pekerjaan])->with('error', 'Data tidak ditemukan.');
    }
}

    public function updateTask(Request $request, $nama_pekerjaan, $task_id)
    {
        try {
            // Mencari task berdasarkan ID dan nama pekerjaan
            $task = Task::where('id', $task_id)
                        ->whereHas('project', function ($query) use ($nama_pekerjaan) {
                            $query->where('nama_pekerjaan', $nama_pekerjaan);
                        })
                        ->firstOrFail();

            // Mengupdate atribut-atribut task dengan data yang dikirimkan melalui request
            $task->update($request->all());

            // Redirect ke halaman proyek yang sesuai setelah berhasil mengupdate tugas
            return redirect()->route('projects.show', ['nama_pekerjaan' => $nama_pekerjaan])->with('success', 'Task berhasil diperbarui');
        } catch (\Exception $e) {
            // Jika task tidak ditemukan atau terjadi kesalahan lain
            return redirect()->route('projects.show', ['nama_pekerjaan' => $nama_pekerjaan])->with('error', 'Gagal memperbarui task');
        }
    }
}
