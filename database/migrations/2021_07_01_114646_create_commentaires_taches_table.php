<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires_taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('text');
            $table->unsignedBigInteger('niveau_evolutions_id');
            $table->foreign('niveau_evolutions_id')->references('id')
            ->on('niveau_evolutions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('taches_id');
            $table->foreign('taches_id')->references('id')
            ->on('taches')->onDelete('cascade');


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
        Schema::dropIfExists('commentaires_taches');
    }
}
