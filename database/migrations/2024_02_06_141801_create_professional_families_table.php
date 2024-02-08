<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    public function up(): void {
        Schema::create('professional_families', function (Blueprint $table) {
            $table->id();
            $table->string('cliteral');
            $table->string('vliteral');
            $table->string('depcurt');
            $table->boolean('didactico')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('professional_families');
    }
};
