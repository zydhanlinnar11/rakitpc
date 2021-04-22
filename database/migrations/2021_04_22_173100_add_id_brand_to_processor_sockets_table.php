<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdBrandToProcessorSocketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processor_sockets', function (Blueprint $table) {
            //
            $table->dropForeign(['id_processor_brand']);
            $table->dropColumn(['id_processor_brand']);
            $table->foreign('id_brand')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processor_sockets', function (Blueprint $table) {
            //
        });
    }
}
