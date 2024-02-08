<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->foreignId('id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('surnames');
            $table->string('urlCV');
            $table->boolean('isActivated')->default(0);
            $table->timestamps();

            $table->primary('id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('students');
    }
};
