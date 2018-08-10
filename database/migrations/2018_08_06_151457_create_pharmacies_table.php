<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('chcode')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable();
            $table->integer('facility_owner')->nullable();
            $table->string('cac_reg')->nullable();
            $table->date('cac_date')->nullable();
            $table->string('fmoh_reg')->nullable();
            $table->date('fmoh_date')->nullable();
            $table->string('chief_pharmacist_reg');
            $table->boolean('active')->default(true);
            $table->string('avatar')->nullable();
            $table->date('chief_pharmacist_reg_date')
                    ->nullable()->comment('MM/YYYY');
            $table->string('chief_pharmacist_name')->nullable();
            $table->string('chief_pharmacist_phone')->nullable();
            $table->text('services')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('pharmacies');
    }
}
