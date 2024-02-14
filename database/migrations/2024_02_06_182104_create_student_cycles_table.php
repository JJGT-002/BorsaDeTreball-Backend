<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    public function up(): void {
        Schema::create('student_cycles', function (Blueprint $table) {
            $table->foreignId('cycle_id')->constrained('cycles')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->year('endDate')->nullable();
            $table->boolean('isValid')->default(0);
            $table->primary(['cycle_id', 'student_id']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_cycles');
    }
};
