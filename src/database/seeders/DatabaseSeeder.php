<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['id' => 1, 'nama' => 'admin']);
        DB::table('roles')->insert(['id' => 2, 'nama' => 'pembeli']);

        // \App\Models\User::factory(10)->create();
        // \App\Models\kategori::factory(5)->create();
        // \App\Models\Brand::factory(5)->create();
        // \App\Models\Subcategory::factory(5)->create();
        // \App\Models\item::factory(20)->create();

    }
}
