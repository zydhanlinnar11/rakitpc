<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategoris')->delete();
        DB::table('kategoris')->insert([
            [
                'id' => 1,
                'nama' => 'Prosesor',
                'url' => 'prosesor',
                'fa_class' => 'fas fa-microchip'
            ],
            [
                'id' => 2,
                'nama' => 'Motherboard',
                'url' => 'motherboard',
                'fa_class' => 'fas fa-chess-board'
            ],
            [
                'id' => 3,
                'nama' => 'Storage',
                'url' => 'Storage',
                'fa_class' => 'fas fa-hdd'
            ],
            [
                'id' => 4,
                'nama' => 'Power Supply',
                'url' => 'power-supply',
                'fa_class' => 'fas fa-plug'
            ],
            [
                'id' => 5,
                'nama' => 'Memory',
                'url' => 'memory',
                'fa_class' => 'fas fa-memory'
            ],
        ]);
    }
}
