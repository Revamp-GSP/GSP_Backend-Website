<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customers;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Customers::create([
            'produk' => 'E-Payment',
            'id_service' => 'S1',
            'nama_service' => 'Payment Gateway',
            'deskripsi' => null,
            'date_added' => now(),
            'date_updated' => null,
            'created_by' => 'Sugih Permana',
        ]);// \App\Models\User::factory(10)->create();
    }
}
