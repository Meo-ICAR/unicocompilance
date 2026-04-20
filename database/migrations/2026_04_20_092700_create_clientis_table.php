<?php

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
        Schema::create('clientis', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID univoco del cliente/banca');
            $table->string('abi', 30)->nullable()->comment('Abi per banche o numero RUI ISVASS');
            $table->string('abi_name')->nullable()->comment('Nome ufficiale banca');
            $table->date('stipulated_at')->nullable()->comment('Data stipula contratto convenzione');
            $table->date('dismissed_at')->nullable()->comment('Data cessazione rapporto convenzione');
            $table->string('type', 30)->nullable()->comment('Banca / Assicurazione / Utility');
            $table->string('oam', 30)->nullable()->comment('Codice di iscrizione OAM');
            $table->string('oam_name')->nullable()->comment('Denominazione OAM');
            $table->date('oam_at')->nullable()->comment('Data iscrizione OAM');
            $table->string('numero_iscrizione_rui', 50)->nullable()->comment('Numero iscrizione OAM');
            $table->string('ivass', 30)->nullable()->comment('Codice di iscrizione IVASS');
            $table->date('ivass_at')->nullable()->comment('Data iscrizione IVASS');
            $table->string('ivass_name')->nullable()->comment('Denominazione OAM');
            $table->enum('ivass_section', ['A', 'B', 'C', 'D', 'E'])->nullable()->comment('Sezione IVASS');
            $table->string('mandate_number', 100)->nullable()->comment('Numero di protocollo o identificativo del contratto di mandato');
            $table->date('start_date')->nullable()->comment('Data di decorrenza del mandato');
            $table->date('end_date')->nullable()->comment('Data di scadenza (NULL se a tempo indeterminato)');
            $table->boolean('is_exclusive')->default(false)->comment('Indica se il mandato prevede l\'esclusiva per quella categoria');
            $table->enum('status', ['ATTIVO', 'SCADUTO', 'RECEDUTO', 'SOSPESO'])->default('ATTIVO')->comment('Stato operativo del mandato');
            $table->text('notes')->nullable()->comment('Note su provvigioni particolari o patti specifici');
            $table->enum('principal_type', ['--', 'banca', 'agente_assicurativo', 'agente_captive'])->default('banca')->comment('Tipologia del mandante');
            $table->enum('submission_type', ['--', 'accesso portale', 'inoltro', 'entrambi'])->default('accesso portale')->comment('Modalità inoltro pratiche');
            $table->string('website')->nullable()->comment('sito web');
            $table->boolean('is_reported')->default(false)->comment('Accordi di segnalazione');
            $table->string('cf')->nullable()->comment('Codice fiscale');
            $table->string('coge')->nullable()->comment('Codice contabile COGE');
            $table->string('codice')->nullable();
            $table->string('name')->nullable();
            $table->string('nome')->nullable();
            $table->string('piva', 16)->nullable();
            $table->string('email')->nullable();
            $table->string('regione')->nullable();
            $table->string('citta')->nullable();
            $table->uuid('company_id')->default('5c044917-15b3-4471-90c9-38061fcca754')->comment('ID dell\'azienda di riferimento');
            $table->unsignedBigInteger('customertype_id')->nullable()->comment('Riferimento al tipo di cliente (chiave esterna)');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_dummy')->default(false);
            $table->softDeletes()->comment('Timestamp di cancellazione (soft delete)');
            $table->timestamps();

            // Indexes
            $table->index('customertype_id');
            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientis');
    }
};
