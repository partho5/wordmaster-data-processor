<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDontConfuseWithsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dont_confuse_with', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('word_id');
            $table->string('confusing_with')->nullable(); // word's id
            $table->mediumText('hint')->nullable();
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
        Schema::dropIfExists('dont_confuse_withs');
    }
}
