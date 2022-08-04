<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookloansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookloans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('credit_code');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('book_id');
            $table->date('borrow_date');
            $table->date('date_of_return');
            $table->enum('status', ['1', '2'])->default(1);
            $table->string('admin');

            $table->foreign('member_id')->on('members')->references('id')->onDelete('RESTRICT');
            $table->foreign('book_id')->on('books')->references('id')->onDelete('RESTRICT');
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
        Schema::dropIfExists('bookloans');
    }
}
