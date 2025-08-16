<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('structure_id')->constrained('structures')->cascadeOnDelete();
            $table->text('texte_question');
            $table->enum('type_question', ['smileys', 'oui_non', 'echelle', 'etoiles', 'texte_libre']);
            $table->boolean('est_active')->default(true);
            $table->integer('ordre_affichage')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};