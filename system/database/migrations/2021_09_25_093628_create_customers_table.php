<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('business_id');
            $table->char('mobile', 20);
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
            
            $table->foreign('created_by')
            ->references('id')->on('users')
            ->onDelete('cascade');

            $table->foreign('business_id')
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
        Schema::dropIfExists('customers');
    }
}
