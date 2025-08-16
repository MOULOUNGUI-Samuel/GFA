<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ticket_id')->unique()->constrained('tickets')->cascadeOnDelete();
            $table->tinyInteger('note_globale')->unsigned()->nullable();
            $table->text('commentaire_general')->nullable();
            $table->ipAddress('ip_address_client')->nullable();
            $table->timestamps(); // created_at sera la date de soumission
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};