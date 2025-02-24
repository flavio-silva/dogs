<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dog_photos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('age');
            $table->unsignedSmallInteger('weight');
            $table->string('path');
            $table->unsignedInteger('views_count')->default(0);
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dogs');
    }
};
