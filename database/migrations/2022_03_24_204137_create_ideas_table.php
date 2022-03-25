<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_id')->nullable();
            $table->integer('category_id');
            $table->integer('user_id');
            $table->integer('academic_year_id');
            $table->string('title');
            $table->string('description');
            $table->string('document_url')->nullable();
            $table->boolean('annonymous');
            $table->integer('last_modified_by')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('ideas');
    }
}
