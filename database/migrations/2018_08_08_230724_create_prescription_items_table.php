<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->integer('frequency');
            $table->string('name');
            $table->string('comments');
            $table->boolean('status')->default(false);
            $table->integer('dispenser_id')->nullable();
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
        Schema::dropIfExists('prescription_items');
    }
}
