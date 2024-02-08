<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    public function up(): void {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('observations');
            $table->string('description');
            $table->string('contractDuration');
            $table->string('contact');
            $table->enum('registrationMethod',['email','atTheMoment']);
            $table->boolean('isActive')->default(0);
            $table->boolean('isDeleted')->default(0);
            $table->boolean('isValid')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('job_offers');
    }
};
