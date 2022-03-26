<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->delete();
        DB::table('items')->insert([
            [
                'id' => 1,
                'nama' => 'AMD Ryzen 3 3100',
                'id_kategori' => 1,
                'id_subkategori' => 1,
                'id_socket' => 1,
                'id_brand' => 1,
                'deskripsi' => '-',
                'berat' => 1,
                'harga' => 2100000,
                'stok' => 5,
                'url_gambar' => 'https://www.amd.com/system/files/styles/992px/private/2020-04/450000-ryzen3-3rd-gen-pib-1260x709_0.png?itok=aakbKqGh',
            ],
            [
                'id' => 2,
                'nama' => 'MSI B450M Pro-VDH Max',
                'id_kategori' => 2,
                'id_subkategori' => 2,
                'id_socket' => 1,
                'id_brand' => 2,
                'deskripsi' => '-',
                'berat' => 2,
                'harga' => 1350000,
                'stok' => 5,
                'url_gambar' => 'https://asset.msi.com/resize/image/global/product/product_6_20190708134634_5d22d8bac2965.png62405b38c58fe0f07fcef2367d8a9ba1/1024.png',
            ],
            [
                'id' => 3,
                'nama' => 'WD_BLACK™ SN750 NVMe™ SSD',
                'id_kategori' => 3,
                'id_subkategori' => 3,
                'id_socket' => null,
                'id_brand' => 3,
                'deskripsi' => '-',
                'berat' => 2,
                'harga' => 1350000,
                'stok' => 5,
                'url_gambar' => 'https://www.westerndigital.com/content/dam/store/en-us/assets/products/internal-storage/wd-black-sn750-nvme-ssd/gallery/without-heatsink/wd-black-sn750-nvme-ssd-noheatsink1.png.wdthumb.1280.1280.webp',
            ],
            [
                'id' => 4,
                'nama' => 'Be Quiet! PURE POWER 11 500w',
                'id_kategori' => 4,
                'id_subkategori' => 4,
                'id_socket' => null,
                'id_brand' => 4,
                'deskripsi' => '-',
                'berat' => 6,
                'harga' => 1250000,
                'stok' => 5,
                'url_gambar' => 'https://www.bequiet.com/admin/ImageServer.php?ID=efa4aa41113@be-quiet.net&omitPreview=true&width=535',
            ],
            [
                'id' => 5,
                'nama' => 'V-GeN TSUNAMI R 3000 Mhz 15-17-17-35',
                'id_kategori' => 5,
                'id_subkategori' => 5,
                'id_socket' => null,
                'id_brand' => 5,
                'deskripsi' => '-',
                'berat' => 1,
                'harga' => 357000,
                'stok' => 5,
                'url_gambar' => 'https://v-gen.co.id/wp-content/uploads/2021/01/16GB-2666-CL-15-1.png',
            ],
        ]);
    }
}
