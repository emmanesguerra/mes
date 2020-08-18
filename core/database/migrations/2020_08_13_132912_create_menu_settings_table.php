<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->primary();
            $table->string('blck_start', 150);
            $table->string('blck_end', 10);
            $table->string('list_dflt', 150);
            $table->string('list_chld', 150);
            $table->string('list_end', 10);
            $table->string('anch_dflt', 150);
            $table->string('anch_chld', 150);
            $table->string('subblck_start', 150)->nullable();
            $table->string('subblck_end', 10)->nullable();
            $table->string('sublist_dflt', 150)->nullable();
            $table->string('sublist_chld', 150)->nullable();
            $table->string('sublist_end', 10)->nullable();
            $table->string('subanch_dflt', 150)->nullable();
            $table->string('subanch_chld', 150)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_settings');
    }
}
