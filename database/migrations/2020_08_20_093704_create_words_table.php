<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('word');
            $table->unsignedBigInteger('display_index')->nullable();
            $table->boolean('is_base_word')->default(1);
            $table->boolean('is_derived_word')->default(0);
            $table->unsignedSmallInteger('importance_level')->default(40);//out of 100
            $table->boolean('is_spelling_noticeable')->default(0);
            $table->boolean('pronunciation')->nullable();
            $table->boolean('pronunciation_audio')->nullable();
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
        Schema::dropIfExists('words');
    }
}
