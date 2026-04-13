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
        Schema::create('gdpr_data_breaches', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id')->comment('Logical FK: db_bpm.companies');
            $table->dateTime('incident_date');
            $table->dateTime('discovery_date');
            $table->string('nature_of_breach', 50)->comment('Enum: unauthorized_access, data_loss, ransomware, etc.');
            $table->integer('subjects_affected_count')->default(0);
            $table->boolean('is_notified_to_authority')->default(false);
            $table->dateTime('notification_date')->nullable();
            $table->text('containment_measures')->nullable();
            $table->string('status', 30)->comment('Enum: investigating, contained, closed');
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->softUserstamps();

            $table->index('company_id', 'idx_compliance_breach_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gdpr_data_breaches');
    }
};
