<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('word_id');
            $table->text('word_note')->nullable();
            $table->longText('mnemonic_note')->nullable();
            $table->text('derivation_note')->nullable();
            $table->text('synonym_note')->nullable();
            $table->text('antonym_note')->nullable();
            $table->text('usage_note')->nullable();
            $table->text('annotation')->nullable();
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
        Schema::dropIfExists('notes');
    }
}
