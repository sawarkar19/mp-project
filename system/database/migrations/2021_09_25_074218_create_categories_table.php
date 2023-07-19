<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('p_id')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type')->default('category')->comment('Type can consist of banner_ads, brand, category, child_attribute, city, coupon, features, gallery, method, offer_ads, parent_attribute, payment_gateway, slider, testimonial');
            $table->integer('featured')->default(0);
            $table->integer('menu_status')->default(0);
            $table->integer('is_admin')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
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
        Schema::dropIfExists('categories');
    }
}
