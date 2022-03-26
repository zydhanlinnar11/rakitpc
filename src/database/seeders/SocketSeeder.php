<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processor_sockets')->delete();
        DB::table('processor_sockets')->insert([
            [
                'id' => 1,
                'nama' => 'AM4',
                'id_brand' => 1,
            ],
        ]);
    }
}
