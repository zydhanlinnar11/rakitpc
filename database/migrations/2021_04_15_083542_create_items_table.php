<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('deskripsi');
            $table->integer('berat', false, true);
            $table->integer('harga', false, true);
            $table->string('url_gambar');
            $table->foreignId('id_kategori');
            $table->foreign('id_kategori')->references('id')->on('kategoris');
            $table->foreignId('id_brand');
            $table->foreign('id_brand')->references('id')->on('brands');
            $table->foreignId('id_subkategori');
            $table->foreign('id_subkategori')->references('id')->on('subcategories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
