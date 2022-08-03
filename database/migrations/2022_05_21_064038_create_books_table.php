<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isbn')->nullable();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('publish_year')->nullable();
            $table->string('price')->nullable();
            $table->string('image')->nullable()->default('img/books/default.jpg');
            $table->string('quantity')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('booklocation_id');
            $table->timestamps();

            $table->foreign('booklocation_id')->references('id')->on('booklocations')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
