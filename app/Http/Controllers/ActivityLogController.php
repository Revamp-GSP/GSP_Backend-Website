<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = LogActivity::with('user')->latest()->paginate(15);
        return view('activity_logs.index', compact('logs'));
    }
    public function deleteAll()
    {
        // Hapus semua catatan aktivitas
        LogActivity::truncate();

        return redirect()->back()->with('success', 'All activity logs have been deleted successfully.');
    }
}
