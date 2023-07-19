<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedeemDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeem_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('redeem_id');
            $table->string('invoice_no', 255)->nullable();
            $table->string('actual_amount')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_value')->nullable();
            $table->string('redeem_amount')->nullable();
            $table->timestamps();

            $table->foreign('redeem_id')
            ->references('id')->on('redeems')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redeem_detail');
    }
}
