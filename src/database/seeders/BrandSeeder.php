<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->delete();
        DB::table('brands')->insert([
            [
                'id' => 1,
                'nama' => 'AMD',
                'url_logo' => 'https://d1ra4hr810e003.cloudfront.net/visual/accountlogo/6D972F55-8581-42E9-B19004B4B9C6882E/small-C96D16F7-8CB9-4345-B9D2F1923BCDFA0E.png',
                'deskripsi' => '-'
            ],
            [
                'id' => 2,
                'nama' => 'MSI',
                'url_logo' => 'https://storage-asset.msi.com/frontend/imgs/logo.png',
                'deskripsi' => '-'
            ],
            [
                'id' => 3,
                'nama' => 'Western Digital',
                'url_logo' => 'https://www.westerndigital.com/content/dam/store/en-us/assets/home-page/brand-logos/western-digital-logo.png.wdthumb.1280.1280.webp',
                'deskripsi' => '-'
            ],
            [
                'id' => 4,
                'nama' => 'Be Quiet!',
                'url_logo' => 'https://www.bequiet.com/en/img/bequiet_logo.png',
                'deskripsi' => '-'
            ],
            [
                'id' => 5,
                'nama' => 'V-GEN',
                'url_logo' => 'https://v-gen.co.id/wp-content/uploads/2019/12/Logo-V-GeN-20-TahunWeb.png',
                'deskripsi' => '-'
            ],
        ]);
    }
}
