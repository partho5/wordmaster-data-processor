<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBottomPopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottom_popups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('short_content')->nullable();
            $table->longText('details_content')->nullable();
            $table->string('positive_btn')->default('Ok');
            $table->string('positive_btn_link')->nullable();
            $table->string('negative_btn')->nullable();
            $table->boolean('fullscreenable')->default(0);
            $table->unsignedMediumInteger('self_dismiss_time')->default(60);//sec
            $table->dateTime('valid_till')->nullable();
            $table->unsignedMediumInteger('repeat_interval')->nullable();//hours. value null means not repeat
            $table->longText('extras')->nullable();
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
        Schema::dropIfExists('bottom_popups');
    }
}
