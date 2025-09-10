<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();

            // Clé étrangère correctement typée
            $table->unsignedBigInteger('personne_id');

            // Champs avec contraintes appropriées
            $table->string('matricule')->unique();
            $table->boolean('accepte_email')->default(false);

            $table->timestamps();

            // Contrainte de clé étrangère
            $table->foreign('personne_id')
                  ->references('id')
                  ->on('personnes')
                  ->onDelete('cascade');

            // Index pour améliorer les performances
            $table->index('matricule');
        });
    }

    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};
