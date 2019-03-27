<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->unique()->index();
            $table->unsignedInteger('owner_id');
            $table->string('api_token', 80)->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->json('address');
            $table->unsignedSmallInteger('household_size');
            $table->json('dimensions');
            $table->json('meta')->nullable();
            $table->timestampTz('last_seen_at')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
