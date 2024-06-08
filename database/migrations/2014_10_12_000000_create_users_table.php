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
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('mobile_country_code')->nullable();
            $table->string('password')->nullable();
            $table->string('status')->default('inactive');
            $table->string('email_otp')->nullable();
            $table->dateTime('email_otp_expiry')->nullable();
            $table->string('mobile_otp')->nullable();
            $table->dateTime('mobile_otp_expiry')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            $table->softDeletes();
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
