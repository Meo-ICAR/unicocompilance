<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processing_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bpm_process_id')->nullable();
            $table->uuid('company_id');
            $table->string('name');
            $table->text('purpose');
            $table->string('lawful_basis');
            $table->json('data_subjects_categories');
            $table->json('personal_data_categories');
            $table->json('recipients_categories');
            $table->string('retention_period');
            $table->boolean('transfers_outside_eu')->default(false);
            $table->text('transfer_safeguards')->nullable();
            $table->text('security_measures_description')->nullable();
            $table->boolean('requires_dpia')->default(false);
            $table->unsignedBigInteger('dpia_id')->nullable();
            $table->date('last_reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'name']);
            $table->index('dpia_id');
            $table->foreign('dpia_id')->references('id')->on('dpias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processing_activities');
    }
};
