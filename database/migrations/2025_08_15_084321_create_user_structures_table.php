<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_structure', function (Blueprint $table) {
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('structure_id')->constrained('structures')->cascadeOnDelete();
            
            // Clé primaire composite pour éviter les doublons
            $table->primary(['user_id', 'structure_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_structure');
    }
};