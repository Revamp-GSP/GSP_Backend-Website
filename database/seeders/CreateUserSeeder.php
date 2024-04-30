<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'kiky',
               'email'=>'pegawai@gsp.co.id',
                'is_admin'=>'0',
               'password'=> bcrypt('123456'),
            ],
            [
                'name'=>'admin',
                'email'=>'admin@gsp.co.id',
                'is_admin'=>'1',
                'password'=> bcrypt('123456'),
             ],
             [
                'name'=>'user',
                'email'=>'user@gsp.co.id',
                 'is_admin'=>'0',
                'password'=> bcrypt('123456'),
             ],
             [
                'name'=>'ba',
                'email'=>'ba@gmail.com',
                 'is_admin'=>'0',
                'password'=> bcrypt('123'),
             ]
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
