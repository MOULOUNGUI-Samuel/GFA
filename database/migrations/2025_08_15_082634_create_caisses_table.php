<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caisses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branche_id')->constrained('branches')->cascadeOnDelete();
            $table->string('nom');
            $table->string('numero_poste', 10)->nullable();
            $table->enum('statut', ['ouverte', 'fermee', 'en_maintenance'])->default('fermee');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};