<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_property', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->string('cust_name')->nullable();
            $table->string('cust_address_line1')->nullable();
            $table->string('cust_address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->integer('total_people')->nullable();
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->string('customer_addharcard_number')->nullable();
            $table->string('customer_addhar_card')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_gateway_id')->nullable();
            $table->string('payment_status')->nullable();
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
        Schema::dropIfExists('book_property');
    }
}
