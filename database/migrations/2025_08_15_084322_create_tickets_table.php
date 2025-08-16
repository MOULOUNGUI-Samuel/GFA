<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('service_id')->constrained('services');
            $table->string('numero_ticket', 10);
            $table->integer('position_attente')->unsigned();
            $table->enum('statut', ['en_attente', 'appele', 'en_cours', 'termine', 'annule', 'absent'])->default('en_attente');
            $table->string('cle_secrete', 32)->unique()->nullable();
            $table->foreignUuid('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('caisse_id')->nullable()->constrained('caisses')->nullOnDelete();
            $table->timestamp('date_appel')->nullable();
            $table->timestamp('date_debut_service')->nullable();
            $table->timestamp('date_fin_service')->nullable();
            $table->timestamps(); // Gère created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};