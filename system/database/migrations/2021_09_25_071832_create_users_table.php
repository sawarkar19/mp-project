<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id')->nullable()->comment('1 - Admin');
            $table->string('name');
            $table->char('mobile', 100);
            $table->string('email')->unique();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('status')->default(1)->comment('0 - Trash, 1 - Active, 2 - Suspended, 3 - Requested');
            $table->timestamps();    

            $table->foreign('created_by')
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
        Schema::dropIfExists('users');
    }
}
