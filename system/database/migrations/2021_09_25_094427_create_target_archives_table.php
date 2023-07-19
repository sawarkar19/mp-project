<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_archives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('offer_subscribe_id');
            $table->char('target', 20);
            $table->integer('status')->default(1);
            $table->timestamps();
            
            $table->foreign('customer_id')
            ->references('id')->on('customers')
            ->onDelete('cascade');

            $table->foreign('offer_subscribe_id')
            ->references('id')->on('offer_subscriptions')
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
        Schema::dropIfExists('target_archives');
    }
}
