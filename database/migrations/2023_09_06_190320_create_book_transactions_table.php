<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_transactions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('book_id');
            $table->string('user_id');
            $table->string('status');
            $table->date('date_back')->nullable();
            $table->date('date_deadline');
            $table->timestamps();
        });

        Schema::table('book_transactions', function($table) {
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_transactions');
    }
}
