<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimePunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_punches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shift')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('edited')->default(0);
            $table->timestamp('clock_in')->nullable();            
            $table->timestamp('clock_out')->nullable();            
            $table->timestamp('shift_date')->nullable(); 
            $table->string('reason')->nullable();           

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('time_punches');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
