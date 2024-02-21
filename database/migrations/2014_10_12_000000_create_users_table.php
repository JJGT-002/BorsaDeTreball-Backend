<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address');
            $table->boolean('accept');
            $table->string('observations')->default('Sin observaciones');
            $table->enum('role',['admin','responsible','student','company']);
            $table->boolean('isActivated')->nullable();
            $table->boolean('isDeleted')->default(0);
            $table->string('token', 100)->nullable()->default(null)->unique();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
