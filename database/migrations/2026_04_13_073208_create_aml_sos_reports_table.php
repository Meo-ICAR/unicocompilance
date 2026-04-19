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
        Schema::create('aml_sos_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id')->comment('Logical FK: db_bpm.companies');
            $table->uuid('agent_id')->comment('Logical FK: db_bpm.users/agents');
            $table->string('practice_reference', 100)->nullable()->comment('Logical FK: db_bpm.practices');
            $table->json('suspicion_indicators')->comment('Bank of Italy anomaly codes');

            // Crea una colonna virtuale estraendo i dati dal JSON, e indicizzala
            $table->string('primary_indicator')->virtualAs('suspicion_indicators->"$[0]"')->index();

            $table->text('internal_evaluation')->nullable();
            $table->boolean('forwarded_to_fiu')->default(false);
            $table->string('fiu_protocol_number', 100)->nullable();
            $table->uuid('receipt_document_id')->nullable()->comment('Logical FK: db_unicodoc.documents');
            $table->string('status', 30)->comment('Enum: drafted, evaluating, reported, archived');
            $table->timestamps();
            $table->softDeletes();

            //   $table->index('company_id', 'idx_aml_company');
            //  $table->index('agent_id', 'idx_aml_agent');
            //    $table->index('practice_reference', 'idx_aml_practice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aml_sos_reports');
    }
};
