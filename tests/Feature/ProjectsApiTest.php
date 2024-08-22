<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;

class ProjectsAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test index endpoint.
     *
     * @return void
     */
    public function testIndex()
    {
        // Create test projects
        Project::create([
            'status' => 'Selesai',
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

        // Hit the endpoint with query parameters if needed
        $response = $this->getJson('/api/projects');

        // Assert HTTP status code and structure of JSON response
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'status',
                             'customer_id',
                             'nama_pelanggan',
                             'product_id',
                             'nama_service',
                             'nama_pekerjaan',
                             'nilai_pekerjaan_rkap',
                             'nilai_pekerjaan_aktual',
                             'nilai_pekerjaan_kontrak_tahun_berjalan',
                             'plan_start_date',
                             'plan_end_date',
                             'actual_start_date',
                             'actual_end_date',
                             'account_marketing',
                             'dirut',
                             'dirop',
                             'dirke',
                             'kskmr',
                             'ksham',
                             'msdmu',
                             'mkakt',
                             'mbilp',
                             'mppti',
                             'mopti',
                             'mbsar',
                             'msadb',
                         ]
                     ]
                 ]);
    }

    /**
     * Test show endpoint.
     *
     * @return void
     */
    public function testShow()
    {
        // Create a test project
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

        // Hit the show endpoint
        $response = $this->getJson('/api/projects/' . $project->id);

        // Assert HTTP status code and structure of JSON response
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $project->id,
                     'status' => 'Follow Up', // Ensure correct data is returned
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
                     // Add more assertions for other fields
                 ]);
    }

    /**
     * Test store endpoint.
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'status' => 'Follow Up',
            'nama_pelanggan' => 'PT Indonesia Comnets Plus',
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
        ];

        // Hit the store endpoint
        $response = $this->postJson('/api/projects', $data);

        // Assert HTTP status code and structure of JSON response
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Project created successfully.',
                     'project' => $data, // Ensure response matches input data
                 ]);

        // Assert that the project was actually created in the database
        $this->assertDatabaseHas('projects', [
            'nama_pelanggan' => 'PT Indonesia Comnets Plus',
            // Add more assertions for other fields
        ]);
    }

    /**
     * Test update endpoint.
     *
     * @return void
     */
    public function testUpdate()
    {
        // Create a test project
        $project = Project::create([
            'status' => 'Follow Up',
            'nama_pelanggan' => 'PT Indonesia Comnets Plus',
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
    
        // Data for update
        $updateData = [
            'status' => 'Selesai',
            'nama_pelanggan' => 'PT Indonesia Comnets Plus',
            'nama_service' => 'Payment Gateway',
            'nama_pekerjaan' => 'Pengadaan Perbaikan Laptop PLN Enjiniring untuk 53 Unit',
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
        ];
    
        // Hit the update endpoint
        $response = $this->putJson('/api/projects/' . $project->id, $updateData);
    
        // Assert HTTP status code and structure of JSON response
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Project updated successfully.',
                     'project' => $updateData, // Ensure response matches updated data
                 ]);
    
        // Assert that the project was actually updated in the database
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => 'Selesai',
            'nama_pekerjaan' => 'Pengadaan Perbaikan Laptop PLN Enjiniring untuk 53 Unit',
            // Add more assertions for other fields if needed
        ]);
    }
    
    /**
     * Test delete endpoint.
     *
     * @return void
     */
    public function testDelete()
{
    $project = Project::create([
        'status' => 'Follow Up',
        'nama_pelanggan' => 'PT Indonesia Comnets Plus',
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

    // Simpan ID proyek untuk digunakan dalam penghapusan
    $projectId = $project->id;

    // Hit the delete endpoint
    $response = $this->deleteJson('/api/projects/' . $projectId);

    // Periksa apakah respons memiliki status 200
    $response->assertStatus(200);
    $response->assertJson(['message' => 'Project deleted successfully.']);


    // Pastikan bahwa proyek tidak ada lagi di database
    $this->assertDatabaseMissing('projects', [
        'id' => $projectId,
    ]);
}
 
}