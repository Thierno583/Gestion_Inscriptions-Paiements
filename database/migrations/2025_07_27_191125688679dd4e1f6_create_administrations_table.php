<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('administrations', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers la table personnes
            $table->foreignId('personne_id')
                  ->constrained('personnes')
                  ->onDelete('cascade'); // Supprime l’administration si la personne est supprimée

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('administrations');
    }
};
