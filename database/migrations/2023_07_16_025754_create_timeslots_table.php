<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeslotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->comment('yang menginput timeslot');
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('odp_id')->nullable();
            $table->foreignId('ont_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('cable_distance')->nullable();
            $table->string('doc')->nullable();

            // kolom tindak lanjut
            $table->foreignId('taken_by')->nullable();
            $table->string('status')->nullable()->default('open')->comment('open, reject, progress, finished');
            $table->timestamp('taken_at')->nullable();
            $table->timestamp('finished_at')->nullable();
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
        Schema::dropIfExists('timeslots');
    }
}
