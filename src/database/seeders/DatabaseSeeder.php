<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\kategori::factory(5)->create();
        \App\Models\Brand::factory(5)->create();
        \App\Models\Subcategory::factory(5)->create();
        \App\Models\item::factory(20)->create();
    }
}
