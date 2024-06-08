<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('primary_img')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('gmap_location')->nullable();
            $table->boolean('AC')->default(false);
            $table->integer('BHK')->nullable();
            $table->text('BHK_desc')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->text('bathrooms_desc')->nullable();
            $table->boolean('swimingpool')->default(false);
            $table->text('swimingpool_desc')->nullable();
            $table->boolean('parking')->default(false);
            $table->boolean('furnished')->default(false);
            $table->boolean('wifi')->default(false);
            $table->boolean('kitchen')->default(false);
            $table->boolean('hot_water')->default(false);
            $table->integer('capacity')->nullable();
            $table->boolean('caretaker')->default(false);
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->json('other_details')->nullable();
            $table->string('status')->default('active');
            $table->string('contact1')->nullable();
            $table->string('contact2')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
