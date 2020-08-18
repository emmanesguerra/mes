<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->text('address');
            $table->string('contact_person')->nullable();
            $table->string('telephone', 100)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('marker');
            $table->string('m_width', 4);
            $table->string('m_height', 4);
            $table->text('store_hours')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('offices');
    }
}
