<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('address')->nullable();
            $table->string('power')->nullable();
            $table->string('jarak_pop')->nullable();
            $table->integer('port_max')->nullable();
            $table->integer('port_used')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('icon')->nullable();
            $table->string('doc')->nullable();
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
        Schema::dropIfExists('odps');
    }
}
