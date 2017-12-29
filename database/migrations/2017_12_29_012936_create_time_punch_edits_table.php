<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimePunchEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_punch_edits', function (Blueprint $table) {
            $table->unsignedInteger('time_punch_id')->unsigned();
            $table->unsignedInteger('user_id')->unsigned();
            $table->timestamp('clock_in')->nullable();            
            $table->timestamp('clock_out')->nullable();
            $table->string('reason')->nullable();

            $table->foreign('time_punch_id')->references('id')->on('time_punches')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'time_punch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_punch_edits');
    }
}
