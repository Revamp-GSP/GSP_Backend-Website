<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\customers;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        customers::create([
            'id_pelanggan' => 'C-1',
            'nama_pelanggan' => 'PT Indonesia Comnets Plus',
            'sebutan' => 'ICON+',
            'date_added' => now(),
            'date_updated' => null,
            'created_by' => 'Sugih Permana',
        ],
    );
    customers::create([
        'id_pelanggan' => 'C-13',
        'nama_pelanggan' => 'PT. PLN (PERSERO) ENJINIRING',
        'sebutan' => 'PLNE',
        'date_added' => now(),
        'date_updated' => null,
        'created_by' => 'Sugih Permana',
    ]);
    }
}
