<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFraisToClassesTable extends Migration
{
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedBigInteger('frais_inscription')->default(0)->after('libelle');
            $table->unsignedBigInteger('frais_mensualite')->default(0)->after('frais_inscription');
            $table->unsignedBigInteger('frais_soutenance')->default(0)->after('frais_mensualite');
        });
    }

    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['frais_inscription', 'frais_mensualite', 'frais_soutenance']);
        });
    }
}
