<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_token', 60)->unique();
            $table->boolean('active')->default('1');
            $table->integer('team_id')->nullable();
            $table->bigInteger('pto')->default(0);
            $table->bigInteger('holiday')->default(0);
            $table->string('username')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state',2)->nullable();
            $table->string('address_zip',5)->nullable();
            $table->string('home_phone_area',3)->nullable();
            $table->string('home_phone_prefix',3)->nullable();
            $table->string('home_phone_number',4)->nullable();
            $table->string('secondary_phone_area',3)->nullable();
            $table->string('secondary_phone_prefix',3)->nullable();
            $table->string('secondary_phone_number',4)->nullable();
            $table->string('emergency_phone_area',3)->nullable();
            $table->string('emergency_phone_prefix',3)->nullable();
            $table->string('emergency_phone_number',4)->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('fire_date')->nullable();
            $table->rememberToken();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
