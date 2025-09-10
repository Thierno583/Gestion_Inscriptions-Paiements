<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();

            // Required fields with appropriate lengths
            $table->string('libelle', 100);
            $table->text('description')->nullable();

            // Timestamps
            $table->timestamps();

            // Index for better performance
            $table->index('libelle');
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
};
