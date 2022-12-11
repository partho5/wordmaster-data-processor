<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payer_mobile')->nullable();
            $table->string('paid_at')->nullable();
            $table->string('paid_amount')->default(0);
            $table->string('coupon_code')->nullable();
            $table->string('auth_token')->nullable();
            $table->text('meta')->nullable();
            $table->string('verified_at')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_payments');
    }
}
