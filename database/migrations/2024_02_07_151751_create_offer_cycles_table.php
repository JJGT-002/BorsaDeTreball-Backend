<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    public function up(): void {
        Schema::create('offer_cycles', function (Blueprint $table) {
                $table->foreignId('job_offer_id')->constrained('job_offers')->onDelete('cascade');
                $table->foreignId('cycle_id')->constrained('cycles')->onDelete('cascade');
                $table->primary(['job_offer_id', 'cycle_id']);
                $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('offer_cycles');
    }
};
