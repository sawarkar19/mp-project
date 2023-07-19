<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by')->comment('It can be business ID or employee ID');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('uuid')->nullable();
            $table->string('subscriber_link',255)->nullable();
            $table->string('share_link',255)->nullable();
            $table->enum('discount_type', ['1','2','3','4']);
            $table->timestamps();

            $table->foreign('created_by')
            ->references('id')->on('users')
            ->onDelete('cascade');
            
            $table->foreign('offer_id')
            ->references('id')->on('offers')
            ->onDelete('cascade');

            $table->foreign('customer_id')
            ->references('id')->on('customers')
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
        Schema::dropIfExists('offer_subscriptions');
    }
}
