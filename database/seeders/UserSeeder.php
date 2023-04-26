<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Aleksandar Stanojevic",
            'email' => "aleksandar.stanojevic@cubes.rs",
            'password' => Hash::make('12345678'),
            'address' => "BMP 181",
            'phone' => '063 123 45 67',
            'role' => 'administrator',
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
