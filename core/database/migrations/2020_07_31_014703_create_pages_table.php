<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('url', '100')->unique();
            $table->string('title', '50');
            $table->string('name', '50');
            $table->string('description', '255');
            $table->text('javascripts');
            $table->text('css');
            $table->string('template', '50');
            $table->text('template_html');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
        
        Schema::create('page_has_contents', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('content_id');
            $table->string('tags');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->primary(['page_id', 'content_id', 'tags'], 'page_has_contents_page_id_content_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_has_contents');
        Schema::dropIfExists('pages');
    }
}
