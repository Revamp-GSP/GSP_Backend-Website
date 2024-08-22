<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\customers;

class CustomersApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_customers()
    {
        // Buat 10 customer secara langsung tanpa factory
        for ($i = 0; $i < 10; $i++) {
            Customers::create([
                'id_pelanggan' => 'ID' . $i,
                'nama_pelanggan' => 'Customer ' . $i,
                'sebutan' => 'Tuan',
                'created_by' => 'Admin'
            ]);
        }

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'data' => [
                    '*' => ['id', 'id_pelanggan', 'nama_pelanggan', 'sebutan', 'created_by', 'created_at', 'updated_at']
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_create_a_customer()
    {
        $customerData = [
            'id_pelanggan' => '12345',
            'nama_pelanggan' => 'John Doe',
            'sebutan' => 'Tuan',
            'created_by' => 'Admin'
        ];

        $response = $this->postJson('/api/customers', $customerData);

        $response->assertStatus(201);
        $response->assertJson(['success' => true, 'message' => 'Customer created successfully.']);

        $this->assertDatabaseHas('customers', [
            'id_pelanggan' => '12345'
        ]);
    }

    /** @test */
    public function it_can_show_a_customer()
    {
        // Buat customer secara langsung tanpa factory
        $customer = Customers::create([
            'id_pelanggan' => '12345',
            'nama_pelanggan' => 'John Doe',
            'sebutan' => 'Tuan',
            'created_by' => 'Admin'
        ]);

        $response = $this->getJson('/api/customers/' . $customer->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $customer->id,
                'id_pelanggan' => $customer->id_pelanggan,
                'nama_pelanggan' => $customer->nama_pelanggan,
                'sebutan' => $customer->sebutan,
                'created_by' => $customer->created_by,
            ]
        ]);
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        // Buat customer secara langsung tanpa factory
        $customer = Customers::create([
            'id_pelanggan' => '12345',
            'nama_pelanggan' => 'John Doe',
            'sebutan' => 'Tuan',
            'created_by' => 'Admin'
        ]);

        $updateData = [
            'id_pelanggan' => '54321',
            'nama_pelanggan' => 'Jane Doe',
            'sebutan' => 'Nona',
            'created_by' => 'Admin2'
        ];

        $response = $this->putJson('/api/customers/' . $customer->id, $updateData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Customer updated successfully.']);

        $this->assertDatabaseHas('customers', [
            'id_pelanggan' => '54321'
        ]);
    }

    /** @test */
    public function it_can_delete_a_customer()
    {
        // Buat customer secara langsung tanpa factory
        $customer = Customers::create([
            'id_pelanggan' => '12345',
            'nama_pelanggan' => 'John Doe',
            'sebutan' => 'Tuan',
            'created_by' => 'Admin'
        ]);

        $response = $this->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Customer deleted successfully.']);

        $this->assertDeleted($customer);
    }
}
