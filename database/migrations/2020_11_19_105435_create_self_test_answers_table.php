<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelfTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_test_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('self_test_id');
            $table->unsignedBigInteger('self_test_question_id');
            $table->string('answered_option')->nullable();
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
        Schema::dropIfExists('self_test_answers');
    }
}
