<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id');
            $table->string('meta_title',255)->nullable();
            $table->string('meta_keyword',255)->nullable();
            $table->string('meta_description',255)->nullable();
            $table->timestamps();

            $table->foreign('page_id')
            ->references('id')->on('pages')
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
        Schema::dropIfExists('seos');
    }
}
