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
        Schema::create('clienti_employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('clienti_id')->nullable();
            $table->uuid('company_id')->nullable();
            $table->string('personable_type')->nullable();
            $table->unsignedBigInteger('personable_id')->nullable();
            $table->string('num_iscr_intermediario')->nullable()->comment('Numero iscrizione intermediario');
            $table->string('num_iscr_collaboratori_ii_liv')->nullable()->comment('Numero iscrizione collaboratori II livello');
            $table->string('usercode')->nullable()->comment('Codice identificativo utente sul portale');
            $table->string('description')->nullable()->comment('Descrizione ruolo o note');
            $table->date('start_date')->nullable()->comment('Data inizio autorizzazione');
            $table->date('end_date')->nullable()->comment('Data fine autorizzazione');
            $table->boolean('is_active')->default(true)->comment('Stato attivo/inattivo');
            $table->timestamps();

            // Indexes
            $table->index(['clienti_id']);
            $table->index(['company_id']);
            $table->index(['personable_type', 'personable_id']);
            $table->index('usercode');
            $table->index('is_active');
            $table->index('start_date');
            $table->index('end_date');

            // Foreign keys
            $table->foreign('clienti_id')->references('id')->on('clientis')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clienti_employees');
    }
};
