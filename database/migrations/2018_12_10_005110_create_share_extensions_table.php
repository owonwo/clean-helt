<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_extensions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('share_id');
            $table->integer('sharer_id');
            $table->string('sharer_type');
            $table->integer('provider_id');
            $table->string('provider_type');
            $table->string('type')->default('assigned');
            $table->enum('status', [0, 1, 2])->default(0);
            $table->dateTime('expired_at');
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
        Schema::dropIfExists('share_extensions');
    }
}
