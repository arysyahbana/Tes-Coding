<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('barangs')->insert([
                'kode' => 'BRG-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nama' => 'Barang ' . chr(64 + $i),
                'harga' => rand(1000, 100000),
            ]);
        }
    }
}
