<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference')->unique();
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->string('type')->default('App\\Models\\Diagnosis');
            $table->string('issuer_type');//The type of person App\Models\Doctor
            $table->integer('issuer_id');//All service provides who issue reports
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void 
     * 
     */
    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
}
