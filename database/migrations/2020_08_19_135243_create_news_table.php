<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->string('short_description', 1000);
            $table->text('description');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('short_description', 1000)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('news_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('parent_id');
            $table->unsignedInteger('lft');
            $table->unsignedInteger('rgt');
            $table->unsignedInteger('lvl');
            $table->string('name')->nullable();
            $table->string('email');
            $table->text('comments');
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
        Schema::dropIfExists('news_comments');
        Schema::dropIfExists('news_categories');
        Schema::dropIfExists('news');
    }
}
