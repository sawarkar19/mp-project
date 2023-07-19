<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_ip',50)->nullable();
            $table->char('mobile',20);
            $table->date('date');
            $table->boolean('is_sent');
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
        Schema::dropIfExists('ip_users');
    }
}
