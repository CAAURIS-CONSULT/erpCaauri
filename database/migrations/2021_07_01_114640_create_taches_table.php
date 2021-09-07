<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('nomTache')->nullable();
            $table->string('description')->nullable();
            $table->string('delaisExec')->nullable();

            $table->unsignedBigInteger('niveau_evolutions_id');
            $table->foreign('niveau_evolutions_id')->references('id')
            ->on('niveau_evolutions')->onDelete('cascade');

            $table->unsignedBigInteger('entreprises_id');
            $table->foreign('entreprises_id')->references('id')
            ->on('entreprises')->onDelete('cascade'); 
            
            $table->unsignedBigInteger('projets_id');
            $table->foreign('projets_id')->references('id')->on('projets')->onDelete('cascade');

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
        Schema::dropIfExists('taches');
    }
}
