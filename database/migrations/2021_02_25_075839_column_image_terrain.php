<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColumnImageTerrain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terrains', function (Blueprint $table) {
            $table->unsignedBigInteger('thumbnail_id')->nullable();
            $table->text('gallary')->nullable();
            $table->foreign('thumbnail_id')->references('id')->on('uploaded_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terrains', function (Blueprint $table) {
            $table->dropColumn('thumbnail_id');
            $table->dropColumn('gallary');
        });
    }
}
