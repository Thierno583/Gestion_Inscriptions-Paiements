<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('personnes', function (Blueprint $table) {
            // Vérifie d'abord que la colonne user_id existe, puis ajoute la FK
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('personnes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
