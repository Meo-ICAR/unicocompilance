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
        Schema::create('gdpr_dsr_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id')->comment('Logical FK: db_bpm.companies');
            $table->string('request_type', 50)->comment('Enum: access, rectification, erasure, portability');
            $table->string('subject_name', 255);
            $table->dateTime('received_at');
            $table->dateTime('due_date');
            $table->unsignedBigInteger('unicodoc_request_id')->nullable()->comment('Logical FK: db_unicodoc.request_registries');
            $table->string('status', 30)->comment('Enum: pending, extended, fulfilled, rejected');
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->softUserstamps();

            $table->index('company_id', 'idx_compliance_dsr_company');
            $table->index('unicodoc_request_id', 'idx_compliance_dsr_unicodoc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gdpr_dsr_requests');
    }
};
