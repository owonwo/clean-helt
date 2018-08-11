<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id');
<<<<<<< HEAD
            $table->integer('quantity');
            $table->integer('frequency');
            $table->string('name');
            $table->integer('pharmacy_id')->nullable();
            // Diagnosis ID at this level might not work
            $table->integer('diagnosis_id')->nullable();
=======
            $table->integer('diagnosis_id')->unsigned()->nullable();
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete('cascade');
>>>>>>> ddb66ab24a8d67fcfee64d923e266a6a40a8c95c
            $table->text('comment')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('prescriptions');
    }
}
