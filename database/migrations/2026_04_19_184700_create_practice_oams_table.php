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
        Schema::create('practice_oams', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('practice_id')->nullable()->comment('ID della pratica associata');
            $table->unsignedBigInteger('oam_code_id')->nullable()->comment('ID del codice OAM associato');
            $table->string('oam_code')->nullable()->comment('Codice OAM prodotto');
            $table->string('oam_name')->nullable()->comment('Codice OAM prodotto');
            $table->string('principal_name')->nullable()->comment('Nome intermediario');
            $table->boolean('is_notconvenctioned')->default(false)->comment('Pratica convenzionata');
            $table->boolean('is_previous')->default(false)->comment('Pratica precedente');
            $table->decimal('liquidato', 10, 2)->nullable()->comment('Importo liquidato');
            $table->decimal('liquidato_lavorazione', 10, 2)->nullable()->comment('Importo liquidato lavorazione');
            $table->string('CRM_code')->nullable()->comment('Codice CRM');
            $table->string('practice_name')->nullable()->comment('Nome pratica');
            $table->string('type')->nullable()->comment('Tipo');
            $table->date('inserted_at')->nullable()->comment('Data inserimento');
            $table->date('erogated_at')->nullable()->comment('Data erogazione');
            $table->decimal('compenso', 10, 2)->nullable()->comment('Compenso totale');
            $table->decimal('compenso_lavorazione', 10, 2)->nullable()->comment('Compenso lavorazione');
            $table->decimal('erogato', 10, 2)->nullable()->comment('Importo erogato');
            $table->decimal('erogato_lavorazione', 10, 2)->nullable()->comment('Importo erogato lavorazione');
            $table->decimal('compenso_premio', 10, 2)->nullable()->comment('Compenso premio assicurativo');
            $table->decimal('compenso_rimborso', 10, 2)->nullable()->comment('Compenso rimborso spese');
            $table->decimal('compenso_assicurazione', 10, 2)->nullable()->comment('Compenso assicurazione');
            $table->decimal('compenso_cliente', 10, 2)->nullable()->comment('Compenso cliente');
            $table->decimal('storno', 10, 2)->nullable()->comment('Importo storno');
            $table->decimal('provvigione', 10, 2)->nullable()->comment('Provvigione totale');
            $table->decimal('provvigione_lavorazione', 10, 2)->nullable()->comment('Provvigione lavorazione');
            $table->decimal('provvigione_premio', 10, 2)->nullable()->comment('Provvigione premio assicurativo');
            $table->decimal('provvigione_rimborso', 10, 2)->nullable()->comment('Provvigione rimborso spese');
            $table->decimal('provvigione_assicurazione', 10, 2)->nullable()->comment('Provvigione assicurazione');
            $table->decimal('provvigione_storno', 10, 2)->nullable()->comment('Provvigione storno');
            $table->boolean('is_active')->default(true)->comment('Campo per escludere manualmente');
            $table->boolean('is_cancel')->default(false)->comment('Pratica stornata');
            $table->boolean('is_perfected')->default(false)->comment('Pratica perfezionata nel periodo');
            $table->boolean('is_conventioned')->default(false)->comment('Pratica convenzionata');
            $table->boolean('is_notconventioned')->default(false)->comment('Pratica non convenzionata');
            $table->boolean('is_working')->default(true)->comment('PracticeOam is working boolean');
            $table->date('invoice_at')->nullable()->comment('Data di fatturazione');
            $table->date('start_date')->nullable()->comment('Data di inizio');
            $table->date('perfected_at')->nullable()->comment('Data di perfezionamento');
            $table->date('end_date')->nullable()->comment('Data di fine');
            $table->date('accepted_at')->nullable()->comment('Data inizio autorizzazione');
            $table->date('canceled_at')->nullable()->comment('Data di storno');
            $table->boolean('is_invoice')->default(false)->comment('Pratica fatturata');
            $table->boolean('is_before')->default(false)->comment('Pratica fatturata');
            $table->boolean('is_after')->default(false)->comment('Pratica fatturata');
            $table->string('name')->nullable()->comment('Mandanti');
            $table->string('tipo_prodotto')->nullable()->comment('Prodotto');
            $table->integer('mese')->nullable()->comment('Mese');
            $table->uuid('company_id')->nullable()->comment('ID azienda');
            $table->timestamps();

            $table->foreign('oam_code_id')->references('id')->on('oam_codes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_oams');
    }
};
