<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    public function up(): void {
        Schema::create('responsible_cycles', function (Blueprint $table) {
            $table->foreignId('responsible_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cycle_id')->constrained('cycles')->onDelete('cascade');
            $table->primary(['responsible_id', 'cycle_id']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('responsible_cycles');
    }
};
