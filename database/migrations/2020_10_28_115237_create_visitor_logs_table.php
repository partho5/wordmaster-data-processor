<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('client')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('email')->nullable();
            $table->string('device_token')->nullable();
            $table->string('reading_start_at');//not null
            $table->string('reading_end_at')->nullable();
            $table->text('url')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();


            /*
             * To query sales report (in affiliate dashboard for example), referred_by is frequently used
             * */
            $table->index('referred_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_logs');
    }
}
