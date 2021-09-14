<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFishingLicenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fishing_licence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users') ->onDelete('cascade');
            $table->string('address');
            $table->tinyInteger('number_of_rods');
            $table->tinyInteger('number_of_fishing_hooks');
            $table->date('valid_from');
            $table->date('valid_to');
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
        Schema::dropIfExists('fishing_licence');
    }
}
