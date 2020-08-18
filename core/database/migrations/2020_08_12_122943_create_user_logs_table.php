<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->dateTime('log_in');
            $table->dateTime('log_out')->nullable();
            $table->string('ip_address', 45)->nullable();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('current_ul_id')->before('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('current_ul_id');
        });
        
        Schema::dropIfExists('user_logs');
    }
}
