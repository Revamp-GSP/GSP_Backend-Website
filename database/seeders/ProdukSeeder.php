<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        // Produk pertama
        Produk::create([
            'produk' => 'E-Payment',
            'id_service' => 'S1',
            'nama_service' => 'Payment Gateway',
            'deskripsi' => null,
            'date_added' => now(),
            'date_updated' => null,
            'created_by' => 'Sugih Permana',
        ]);

        // Produk kedua
        Produk::create([
            'produk' => 'IT Services',
            'id_service' => 'S2',
            'nama_service' => 'Data Centre',
            'deskripsi' => null,
            'date_added' => now(),
            'date_updated' => null,
            'created_by' => 'Sugih Permana',
        ]);

        // Produk ketiga
        Produk::create([
            'produk' => 'Apps Services',
            'id_service' => 'S3',
            'nama_service' => 'Web Apps',
            'deskripsi' => null,
            'date_added' => now(),
            'date_updated' => null,
            'created_by' => 'Sugih Permana',
        ]);
        Produk::create([
            'produk' => '',
            'id_service' => 'S6',
            'nama_service' => 'IT-SERVICE',
            'deskripsi' => null,
            'date_added' => now(),
            'date_updated' => null,
            'created_by' => 'Sugih Permana',
        ]);
    }
}
