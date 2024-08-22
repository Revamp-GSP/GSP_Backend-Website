<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Project;
use App\Notifications\ProjectCreatedNotification;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetNotificationsSuccess()
    {
        // Membuat pengguna sebagai penerima notifikasi
        $user = User::factory()->create();
    
        // Menyiapkan objek proyek palsu
        $project = Project::create([
            'status' => 'Follow Up',
            'customer_id' => null,
            'nama_pelanggan' => 'PT Indonesia Comnets Plus',
            'product_id' => null,
            'nama_service' => 'Payment Gateway',
            'nama_pekerjaan' => 'Pengadaan Perbaikan Laptop PLN Enjiniring untuk 52 Unit',
            'nilai_pekerjaan_rkap' => '12312332.00',
            'nilai_pekerjaan_aktual' => '321321231.00',
            'nilai_pekerjaan_kontrak_tahun_berjalan' => '3213223.00',
            'plan_start_date' => '0002-02-22',
            'plan_end_date' => '0002-02-22',
            'actual_start_date' => '0002-02-22',
            'actual_end_date' => '0002-02-22',
            'account_marketing' => 'Olley Mosye',
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
            'mbsar' => 'Accountable',
            'msadb' => 'Accountable',
        ]);
    
        // Mengirimkan notifikasi dengan objek proyek yang telah disiapkan
        Notification::fake();
        $user->notify(new ProjectCreatedNotification($project));
    
        // Melakukan pengambilan notifikasi dengan autentikasi
        $response = $this->actingAs($user)
                         ->getJson('/notifications');
    
        // Memeriksa bahwa respons dari endpoint /notifications adalah HTTP 200 OK
        $response->assertStatus(200);
    
        // Memeriksa bahwa respons JSON memiliki struktur yang diharapkan
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'type',
                    'notifiable_id',
                    'data' => [
                        'message',
                        'project_id',
                        'project_name',
                        'read_at',
                    ],
                ],
            ],
        ]);
    }
    
}
