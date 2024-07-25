<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('customers')->insert([
                'kode' => 'CTM-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'name' => 'Customer ' . chr(65 + $i),
                'telp' => '08' . rand(1000000000, 9999999999),
            ]);
        }
    }
}
