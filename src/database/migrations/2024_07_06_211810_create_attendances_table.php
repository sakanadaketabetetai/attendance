<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('clock_in_time')->nullable()->default(null);
            $table->dateTime('clock_out_time')->nullable()->default(null);
            $table->time('total_clock_time')->nullable()->default(null);
            $table->time('total_break_time')->nullable()->default(null);
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
        Schema::dropIfExists('attendances');
    }
}
