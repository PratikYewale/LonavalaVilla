<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties');
            $table->double('weekend_mrp')->nullable();
            $table->double('weekend_sp')->nullable();
            $table->double('weekend_discount')->nullable();
            $table->double('weekoff_mrp')->nullable();
            $table->double('weekoff_sp')->nullable();
            $table->double('weekoff_discount')->nullable();
            $table->double('security_deposit')->nullable();
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
        Schema::dropIfExists('prices');
    }
}
