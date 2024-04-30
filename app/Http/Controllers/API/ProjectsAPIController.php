<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Produk;

class ProjectsAPIController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

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
        return response()->json($projects);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'customer_id' => 'sometimes|exists:customers,id',
            'product_id' => 'sometimes|exists:produks,id',
            // tambahkan validasi lainnya di sini sesuai kebutuhan
        ]);

        // Create the project
        $project = Project::create($request->all());

        return response()->json(['message' => 'Project created successfully.', 'project' => $project], 201);
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'customer_id' => 'sometimes|exists:customers,id',
            'product_id' => 'sometimes|exists:produks,id',
            // tambahkan validasi lainnya di sini sesuai kebutuhan
        ]);

        // Update the project
        $project = Project::findOrFail($id);
        $project->update($request->all());

        return response()->json(['message' => 'Project updated successfully.', 'project' => $project]);
    }

    public function destroy($id)
    {
        // Delete the project
        Project::findOrFail($id)->delete();
        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
