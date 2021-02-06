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
            $table->id('user_id');
            $table->string('user_email', 191)->unique();
            $table->string('user_password');
            $table->string('user_salt');
            $table->string('user_name')->nullable();
            $table->string('user_address')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_group')->default('default');
            $table->timestamp('user_email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
