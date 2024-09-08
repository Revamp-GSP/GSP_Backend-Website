<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskAPIControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test storing a new task.
     *
     * @return void
     */
    public function testStoreTask()
{
    // Buat proyek untuk menyimpan tugas
    $project = Project::create([
        'nama_pekerjaan' => 'Pengadaan Perbaikan Laptop PLN Enjiniring untuk 52 Unit',
        'status' => 'Follow Up',
        'nama_pelanggan' => 'PT Indonesia Comnets Plus',
        'nama_service' => 'Payment Gateway',
        'nilai_pekerjaan_rkap' => '233123232.00',
        'nilai_pekerjaan_aktual' => '321321321.00',
        'nilai_pekerjaan_kontrak_tahun_berjalan' => '321323223.00',
        'plan_start_date' => '0002-02-22',
        'plan_end_date' => '0002-02-22',
        'actual_start_date' => '0002-02-22',
        'actual_end_date' => '0002-02-22',
        'account_marketing' => 'Admin Sales',
        'dirut' => 'Responsible',
        'dirop' => 'Accountable',
        'dirke' => 'Support',
        'kskmr' => 'Consulted',
        'ksham' => 'Informed',
        'msdmu' => 'Consulted',
        'mkakt' => 'Support',
        'mbilp' => 'Accountable',
        'mppti' => 'Responsible',
        'mopti' => 'Accountable',
        'mbsar' => 'Responsible',
        'msadb' => 'Responsible',
    ]);

    // Data untuk menyimpan tugas
    $taskData = [
        'program_kegiatan' => 'Program Kegiatan 1',
        'plan_date_start' => '2023-01-01',
        'plan_date_end' => '2023-01-15',
        'actual_date_start' => '2023-01-02',
        'actual_date_end' => '2023-01-14',
        'nama_task' => 'Task 1',
        'pic' => 'PIC 1',
        'divisi_terkait' => 'Divisi 1',
        'keterangan' => 'Keterangan 1',
    ];

    // Encode nama_pekerjaan untuk URL
    $encodedNamaPekerjaan = rawurlencode($project->nama_pekerjaan);

    // Hit the store endpoint
    $url = '/api/projects/' . $encodedNamaPekerjaan . '/tasks';
    $response = $this->postJson($url, $taskData);

    // Assert API response
    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Task berhasil ditambahkan.', // Pastikan pesan sesuai dengan yang dikembalikan oleh API
            'task' => [
                'project_id' => $project->id,
                'program_kegiatan' => 'Program Kegiatan 1',
                'plan_date_start' => '2023-01-01',
                'plan_date_end' => '2023-01-15',
                'actual_date_start' => '2023-01-02',
                'actual_date_end' => '2023-01-14',
                'nama_task' => 'Task 1',
                'pic' => 'PIC 1',
                'divisi_terkait' => 'Divisi 1',
                'keterangan' => 'Keterangan 1',
                'id' => $response->json('task.id'), // Periksa ID yang dikembalikan
                // Jika Anda ingin memeriksa atribut lain, tambahkan di sini
            ],
        ]);

    // Pastikan bahwa tugas telah disimpan di database
    $this->assertDatabaseHas('tasks', [
        'project_id' => $project->id,
        'nama_task' => 'Task 1',
        'pic' => 'PIC 1',
        'divisi_terkait' => 'Divisi 1',
        'keterangan' => 'Keterangan 1',
    ]);
}

    /**
 * Test getting tasks by project name.
 *
 * @return void
 */
public function testGetTasksByNamaPekerjaan()
{
    // Persiapkan data proyek secara langsung
    $project = Project::create([
        'nama_pekerjaan' => 'Pengadaan Perbaikan Laptop PLN Enjiniring untuk 52 Unit',
        'status' => 'Follow Up',
        'nama_pelanggan' => 'PT Indonesia Comnets Plus',
        'nama_service' => 'Payment Gateway',
        'nilai_pekerjaan_rkap' => '233123232.00',
        'nilai_pekerjaan_aktual' => '321321321.00',
        'nilai_pekerjaan_kontrak_tahun_berjalan' => '321323223.00',
        'plan_start_date' => '0002-02-22',
        'plan_end_date' => '0002-02-22',
        'actual_start_date' => '0002-02-22',
        'actual_end_date' => '0002-02-22',
        'account_marketing' => 'Admin Sales',
        'dirut' => 'Responsible',
        'dirop' => 'Accountable',
        'dirke' => 'Support',
        'kskmr' => 'Consulted',
        'ksham' => 'Informed',
        'msdmu' => 'Consulted',
        'mkakt' => 'Support',
        'mbilp' => 'Accountable',
        'mppti' => 'Responsible',
        'mopti' => 'Accountable',
        'mbsar' => 'Responsible',
        'msadb' => 'Responsible',
    ]);

    // Data untuk disimpan sebagai task baru
    $data = [
        'project_id' => $project->id,
        'program_kegiatan' => 'Program Kegiatan 1',
        'plan_date_start' => '2023-01-01',
        'plan_date_end' => '2023-01-15',
        'actual_date_start' => '2023-01-02',
        'actual_date_end' => '2023-01-14',
        'nama_task' => 'Task 1',
        'pic' => 'PIC 1',
        'divisi_terkait' => 'Divisi 1',
        'keterangan' => 'Keterangan 1',
    ];

    // Encode nama_pekerjaan untuk URL
    $encodedNamaPekerjaan = rawurlencode($project->nama_pekerjaan);

    // Panggil endpoint untuk menyimpan task baru
    $url = '/api/projects/' . $encodedNamaPekerjaan . '/tasks';
    $response = $this->postJson($url, $data);

    // Periksa respons yang diharapkan
    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Task berhasil ditambahkan.',
            'task' => $data // Sesuaikan dengan struktur yang Anda harapkan
        ]);

    // Pastikan respons tidak mengandung kolom yang tidak diharapkan
    $response->assertJsonMissing([
        'id',
        'created_at',
        'updated_at',
    ]);
}

public function testUpdateTask()
{
    // Buat proyek dan tugas terkait
    $project = Project::create([
        'nama_pekerjaan' => 'Pengadaan Perbaikan Laptop PLN Enjiniring untuk 52 Unit',
        'status' => 'Follow Up',
        'nama_pelanggan' => 'PT Indonesia Comnets Plus',
        'nama_service' => 'Payment Gateway',
        'nilai_pekerjaan_rkap' => '233123232.00',
        'nilai_pekerjaan_aktual' => '321321321.00',
        'nilai_pekerjaan_kontrak_tahun_berjalan' => '321323223.00',
        'plan_start_date' => '0002-02-22',
        'plan_end_date' => '0002-02-22',
        'actual_start_date' => '0002-02-22',
        'actual_end_date' => '0002-02-22',
        'account_marketing' => 'Admin Sales',
        'dirut' => 'Responsible',
        'dirop' => 'Accountable',
        'dirke' => 'Support',
        'kskmr' => 'Consulted',
        'ksham' => 'Informed',
        'msdmu' => 'Consulted',
        'mkakt' => 'Support',
        'mbilp' => 'Accountable',
        'mppti' => 'Responsible',
        'mopti' => 'Accountable',
        'mbsar' => 'Responsible',
        'msadb' => 'Responsible',
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'program_kegiatan' => 'Program Kegiatan 1',
        'plan_date_start' => '2023-01-01',
        'plan_date_end' => '2023-01-15',
        'actual_date_start' => '2023-01-02',
        'actual_date_end' => '2023-01-14',
        'pic' => 'PIC 1',
        'divisi_terkait' => 'Divisi 1',
        'keterangan' => 'Keterangan 1',
    ]);

    // Data untuk pembaruan tugas
    $updateData = [
        'project_id' => $project->id,
        'program_kegiatan' => 'Program Kegiatan Baru',
        'plan_date_start' => '2023-02-01',
        'plan_date_end' => '2023-02-15',
        'actual_date_start' => '2023-02-02',
        'actual_date_end' => '2023-02-14',
        'pic' => 'PIC Baru',
        'divisi_terkait' => 'Divisi Baru',
        'keterangan' => 'Keterangan Baru',
    ];

    // Panggil endpoint untuk memperbarui tugas
    $encodedNamaPekerjaan = rawurlencode($project->nama_pekerjaan);
    $url = '/api/projects/' . $encodedNamaPekerjaan . '/tasks/' . $task->id;
    $response = $this->putJson($url, $updateData);

    // Pastikan respons dari API
    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Task berhasil diperbarui.',
            'task' => $updateData,
        ]);

    // Perbarui instance $task dengan data terbaru dari database
    $task = $task->fresh();

    // Pastikan tugas telah diperbarui di database
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'project_id' => $project->id,
        'program_kegiatan' => 'Program Kegiatan Baru',
        'plan_date_start' => '2023-02-01',
        'plan_date_end' => '2023-02-15',
        'actual_date_start' => '2023-02-02',
        'actual_date_end' => '2023-02-14',
        'pic' => 'PIC Baru',
        'divisi_terkait' => 'Divisi Baru',
        'keterangan' => 'Keterangan Baru',
    ]);
}

public function testDeleteTask()
{
    // Buat proyek dan tugas terkait
    $project = Project::create([
        'nama_pekerjaan' => 'Pengadaan Perbaikan Laptop PLN Enjiniring untuk 52 Unit',
        'status' => 'Follow Up',
        'nama_pelanggan' => 'PT Indonesia Comnets Plus',
        'nama_service' => 'Payment Gateway',
        'nilai_pekerjaan_rkap' => '233123232.00',
        'nilai_pekerjaan_aktual' => '321321321.00',
        'nilai_pekerjaan_kontrak_tahun_berjalan' => '321323223.00',
        'plan_start_date' => '0002-02-22',
        'plan_end_date' => '0002-02-22',
        'actual_start_date' => '0002-02-22',
        'actual_end_date' => '0002-02-22',
        'account_marketing' => 'Admin Sales',
        'dirut' => 'Responsible',
        'dirop' => 'Accountable',
        'dirke' => 'Support',
        'kskmr' => 'Consulted',
        'ksham' => 'Informed',
        'msdmu' => 'Consulted',
        'mkakt' => 'Support',
        'mbilp' => 'Accountable',
        'mppti' => 'Responsible',
        'mopti' => 'Accountable',
        'mbsar' => 'Responsible',
        'msadb' => 'Responsible',
    ]);

    $task = Task::create([
        'project_id' => $project->id,
        'program_kegiatan' => 'Program Kegiatan 1',
        'plan_date_start' => '2023-01-01',
        'plan_date_end' => '2023-01-15',
        'actual_date_start' => '2023-01-02',
        'actual_date_end' => '2023-01-14',
        'nama_task' => 'Task 1',
        'pic' => 'PIC 1',
        'divisi_terkait' => 'Divisi 1',
        'keterangan' => 'Keterangan 1',
    ]);

    // Encode nama_pekerjaan dan task_id untuk URL
    $encodedNamaPekerjaan = rawurlencode($project->nama_pekerjaan);
    $task_id = $task->id;

    // Hit the delete endpoint
    $url = '/api/projects/' . $encodedNamaPekerjaan . '/tasks/' . $task_id;
    $response = $this->deleteJson($url);

    // Pastikan respons dari API
    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Task berhasil dihapus.',
        ]);

    // Pastikan bahwa tugas telah dihapus dari database
    $this->assertDeleted('tasks', ['id' => $task->id]);
}

}
