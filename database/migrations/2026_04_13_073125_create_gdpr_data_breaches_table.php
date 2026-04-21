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
        Schema::connection('mysql_compliance')->create('gdpr_data_breaches', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id')->comment('Logical FK: db_bpm.companies');
            $table->string('name');
            $table->dateTime('incident_date');
            $table->dateTime('discovery_date');
            $table->string('nature_of_breach', 50)->comment('Enum: unauthorized_access, data_loss, ransomware, etc.');
            $table->string('risk_level', 255)->nullable();
            $table->text('likely_consequences')->nullable();
            $table->integer('approximate_records_count')->default(0);
            $table->integer('subjects_affected_count')->default(0);

            $table->text('description');
            $table->json('data_categories_involved');

            $table->text('containment_measures')->nullable();
            $table->string('status', 30)->comment('Enum: investigating, contained, closed');
            $table->text('mitigation_measures')->nullable();

            $table->timestamp('authority_notified_at')->nullable();
            $table->text('authority_notification_delay_reason')->nullable();

            $table->timestamp('subjects_notified_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            //  $table->index('company_id', 'idx_compliance_breach_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_compliance')->dropIfExists('gdpr_data_breaches');
    }
};
