<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('structure_id')->constrained('structures')->cascadeOnDelete();
            $table->string('nom');
            $table->string('code_branche', 10)->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('adresse')->nullable();
            $table->json('horaires_ouverture')->nullable();
            $table->boolean('est_ouverte')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};