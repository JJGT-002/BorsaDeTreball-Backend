<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('surnames');
            $table->string('urlCV')->nullable();
            $table->boolean('isActivated')->default(0);
            //$table->foreignId('cycle_id')->nullable()->constrained('cycles')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void {
        //Schema::table('students', function (Blueprint $table) {
          //  $table->dropForeign(['cycle_id']);
        //});
        Schema::dropIfExists('students');
    }
};
