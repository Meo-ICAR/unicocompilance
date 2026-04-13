<?php

declare(strict_types=1);

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
        Schema::create('suspicious_activity_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            
            // Polimorfica per il segnalatore (Agent o Employee)
            $table->string('reporter_type');
            $table->unsignedBigInteger('reporter_id');
            
            $table->json('anomalies_codes')->nullable();
            $table->text('description');
            $table->enum('status', ['pending', 'investigated', 'reported', 'archived'])->default('pending');
            $table->timestamp('reported_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['reporter_type', 'reporter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspicious_activity_reports');
    }
};
