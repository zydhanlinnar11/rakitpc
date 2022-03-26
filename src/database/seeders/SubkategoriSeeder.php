<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubkategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategories')->delete();
        DB::table('subcategories')->insert([
            [
                'id' => 1,
                'nama' => 'Prosesor AMD AM4',
                'slug' => 'prosesor-amd-am4',
                'id_kategori' => 1,
                'deskripsi' => '-'
            ],
            [
                'id' => 2,
                'nama' => 'Motherboard AMD AM4',
                'slug' => 'motherboard-amd-am4',
                'id_kategori' => 2,
                'deskripsi' => '-'
            ],
            [
                'id' => 3,
                'nama' => 'SSD NVMe',
                'slug' => 'ssd-nvme',
                'id_kategori' => 3,
                'deskripsi' => '-'
            ],
            [
                'id' => 4,
                'nama' => 'Semi-Modular',
                'slug' => 'semi-modular',
                'id_kategori' => 4,
                'deskripsi' => '-'
            ],
            [
                'id' => 5,
                'nama' => 'DDR4',
                'slug' => 'ddr4',
                'id_kategori' => 5,
                'deskripsi' => '-'
            ],
        ]);
    }
}
