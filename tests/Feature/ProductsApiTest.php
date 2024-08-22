<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Produk;

class ProductsApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_products()
    {
        // Buat 10 produk secara langsung tanpa factory
        for ($i = 0; $i < 10; $i++) {
            Produk::create([
                'produk' => 'Produk ' . $i,
                'id_service' => 'ServiceID' . $i,
                'nama_service' => 'Service ' . $i,
                'deskripsi' => 'Deskripsi untuk produk ' . $i,
                'created_by' => 'Admin'
            ]);
        }

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'data' => [
                    '*' => ['id', 'produk', 'id_service', 'nama_service', 'deskripsi', 'created_by', 'created_at', 'updated_at']
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $productData = [
            'produk' => 'Test Product',
            'id_service' => 'ServiceID123',
            'nama_service' => 'Service Name',
            'deskripsi' => 'Test Description',
            'created_by' => 'Admin'
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201);
        $response->assertJson(['success' => true, 'message' => 'Product created successfully.']);

        $this->assertDatabaseHas('produks', [
            'produk' => 'Test Product'
        ]);
    }

    /** @test */
    public function it_can_show_a_product()
    {
        // Buat produk secara langsung tanpa factory
        $product = Produk::create([
            'produk' => 'Test Product',
            'id_service' => 'ServiceID123',
            'nama_service' => 'Service Name',
            'deskripsi' => 'Test Description',
            'created_by' => 'Admin'
        ]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'produk' => $product->produk,
                'id_service' => $product->id_service,
                'nama_service' => $product->nama_service,
                'deskripsi' => $product->deskripsi,
                'created_by' => $product->created_by,
            ]
        ]);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        // Buat produk secara langsung tanpa factory
        $product = Produk::create([
            'produk' => 'Test Product',
            'id_service' => 'ServiceID123',
            'nama_service' => 'Service Name',
            'deskripsi' => 'Test Description',
            'created_by' => 'Admin'
        ]);

        $updateData = [
            'produk' => 'Updated Product',
            'id_service' => 'UpdatedServiceID',
            'nama_service' => 'Updated Service Name',
            'deskripsi' => 'Updated Description',
            'created_by' => 'Admin2'
        ];

        $response = $this->putJson('/api/products/' . $product->id, $updateData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Product updated successfully.']);

        $this->assertDatabaseHas('produks', [
            'produk' => 'Updated Product'
        ]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        // Buat produk secara langsung tanpa factory
        $product = Produk::create([
            'produk' => 'Test Product',
            'id_service' => 'ServiceID123',
            'nama_service' => 'Service Name',
            'deskripsi' => 'Test Description',
            'created_by' => 'Admin'
        ]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Product deleted successfully.']);

        $this->assertDeleted($product);
    }
}
