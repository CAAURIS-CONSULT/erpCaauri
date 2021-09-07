<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessourcesTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressources_taches', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('lien')->nullable();
            $table->unsignedBigInteger('taches_id');
            $table->foreign('taches_id')->references('id')
            ->on('taches')->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')
            ->on('type_ressources')->onDelete('cascade');
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
        Schema::dropIfExists('ressources_taches');
    }
}
