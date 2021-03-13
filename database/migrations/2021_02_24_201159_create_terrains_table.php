<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->string('floor_type', 10, 2)->nullable();
            $table->string('city', 10, 2)->nullable();
            $table->string('adress')->nullable();
            $table->string('google_latitude')->nullable();
            $table->string('google_attitude')->nullable();
            $table->boolean('has_arbite')->nullable();

            $table->unsignedBigInteger('type_terrain_id')->nullable();
            $table->foreign('type_terrain_id')->references('id')->on('type_terrains');

            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');

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
        Schema::dropIfExists('terrains');
    }
}
