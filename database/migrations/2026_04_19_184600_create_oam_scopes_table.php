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
        Schema::create('oam_scopes', function (Blueprint $table) {
            $table->id()->comment('ID autoincrementante');
            $table->string('code')->nullable()->comment('Codice ambito OAM');
            $table->string('name')->nullable()->comment('Descrizione ambito operativo');
            $table->string('description')->nullable()->comment('Codice e Descrizione ambito operativo');
            $table->string('tipo_prodotto')->nullable()->comment('Lista di tipi prodotto da PracticeOam');
            $table->timestamps();
            
            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oam_scopes');
    }
};
