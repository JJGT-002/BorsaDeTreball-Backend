<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    public function up(): void {
        Schema::create('cycles', function (Blueprint $table) {
            $table->id();
            $table->string('ciclo');
            $table->foreignId('departamento')->constrained('professional_families')->onDelete('cascade');
            $table->string('tipo');
            $table->string('normativa');
            $table->string('titol')->nullable();
            $table->string('rd')->nullable();
            $table->string('rd2')->nullable();
            $table->string('vliteral');
            $table->string('cliteral');
            $table->string('horasFct')->nullable();
            $table->string('acronim')->nullable();
            $table->string('llocTreball')->nullable();
            $table->string('dataSignaturaDual')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cycles');
    }
};
