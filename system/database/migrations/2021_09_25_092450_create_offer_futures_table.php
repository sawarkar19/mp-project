<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferFuturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_futures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('share_target');
            $table->string('offer_banner', 255);
            $table->text('offer_description');
            $table->text('redeem_details')->nulllable();
            $table->string('promotion_url', 255)->nulllable();
            $table->string('coupon_type', 255)->nulllable();
            $table->string('coupon_code', 255)->nulllable();
            $table->enum('discount_type', ['Percentage', 'Fixed']);
            $table->integer('discount_value', 20)->nulllable();
            $table->enum('template_type', ['portrait', 'landscape', 'square']);
            $table->unsignedBigInteger('template_id');
            $table->tinyInteger('is_invoice')->default(0);
            $table->string('location', 255)->nulllable();
            $table->unsignedBigInteger('state_id')->nulllable();
            $table->unsignedBigInteger('city_id')->nulllable();
            $table->timestamps();
            
            $table->foreign('offer_id')
            ->references('id')->on('offers')
            ->onDelete('cascade');

            $table->foreign('state_id')
            ->references('id')->on('states')
            ->onDelete('cascade');

            $table->foreign('city_id')
            ->references('id')->on('cities')
            ->onDelete('cascade');

            $table->foreign('template_id')
            ->references('id')->on('templates')
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
        Schema::dropIfExists('offer_futures');
    }
}
