<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;

class DownloadController extends Controller
{
    public function downloadFile($filename)
    {
        // Cari task berdasarkan nama file
        $task = Task::where('dokumen_output', $filename)->first();

        // Pastikan file ditemukan dalam database
        if (!$task) {
            abort(404);
        }

        // Ambil data file (misalnya, data blob atau binary) dari model
        $fileData = $task->dokumen_output; 

        // Set header untuk tipe konten yang sesuai
        $headers = [
            'Content-Type' => 'application/pdf', // Sesuaikan dengan tipe konten file yang sesuai
        ];

        // Berikan respons untuk mengunduh file
        return response($fileData, 200, $headers);
    }
}
