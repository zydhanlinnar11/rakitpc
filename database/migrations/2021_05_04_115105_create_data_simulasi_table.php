<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSimulasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_simulasi', function (Blueprint $table) {
            $table->id();
            $table->string('id_simulasi', 11)->unique();
            $table->boolean('kompatibilitas');
            $table->foreignId('id_brand')->nullable();
            $table->foreign('id_brand')->references('id')->on('brands')->onDelete('cascade');
            $table->foreignId('id_socket')->nullable();
            $table->foreign('id_socket')->references('id')->on('processor_sockets')->onDelete('cascade');
            $table->foreignId('id_prosesor')->nullable();
            $table->foreign('id_prosesor')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_prosesor', false, true)->nullable();
            $table->foreignId('id_motherboard')->nullable();
            $table->foreign('id_motherboard')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_motherboard', false, true)->nullable();
            $table->foreignId('id_ram')->nullable();
            $table->foreign('id_ram')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_ram', false, true)->nullable();
            $table->foreignId('id_hard_disk')->nullable();
            $table->foreign('id_hard_disk')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_hard_disk', false, true)->nullable();
            $table->foreignId('id_ssd')->nullable();
            $table->foreign('id_ssd')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_ssd', false, true)->nullable();
            $table->foreignId('id_casing')->nullable();
            $table->foreign('id_casing')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_casing', false, true)->nullable();
            $table->foreignId('id_graphics_card')->nullable();
            $table->foreign('id_graphics_card')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_graphics_card', false, true)->nullable();
            $table->foreignId('id_power_supply')->nullable();
            $table->foreign('id_power_supply')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_power_supply', false, true)->nullable();
            $table->foreignId('id_keyboard')->nullable();
            $table->foreign('id_keyboard')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_keyboard', false, true)->nullable();
            $table->foreignId('id_mouse')->nullable();
            $table->foreign('id_mouse')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_mouse', false, true)->nullable();
            $table->foreignId('id_monitor')->nullable();
            $table->foreign('id_monitor')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_monitor', false, true)->nullable();
            $table->foreignId('id_cpu_cooler')->nullable();
            $table->foreign('id_cpu_cooler')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_cpu_cooler', false, true)->nullable();
            $table->foreignId('id_software')->nullable();
            $table->foreign('id_software')->references('id')->on('items')->onDelete('set null');
            $table->integer('jumlah_software', false, true)->nullable();
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
        Schema::dropIfExists('data_simulasi');
    }
}
