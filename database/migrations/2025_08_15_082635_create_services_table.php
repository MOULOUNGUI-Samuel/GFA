<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branche_id')->constrained('branches')->cascadeOnDelete();
            $table->string('nom');
            $table->char('prefixe_ticket', 1)->unique();
            $table->integer('temps_moyen_estime')->unsigned()->nullable()->comment('En minutes');
            $table->boolean('est_actif')->default(true);
            $table->integer('ordre_affichage')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};