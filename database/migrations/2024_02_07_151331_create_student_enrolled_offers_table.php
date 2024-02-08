<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    public function up(): void {
        Schema::create('student_enrolled_offers', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('job_offer_id')->constrained('job_offers')->onDelete('cascade');
            $table->primary(['student_id', 'job_offer_id']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_enrolled_offers');
    }
};
