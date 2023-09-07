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
            $table->string('id')->primary();
            $table->string('book_name');
            $table->longText('synopsis');
            $table->string('author');
            $table->string('year');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('stock');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('books', function($table) {
            $table->foreign('category')->references('id')->on('book_categories')->onDelete('cascade');
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
