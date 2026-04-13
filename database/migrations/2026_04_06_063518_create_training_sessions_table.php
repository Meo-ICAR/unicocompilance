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
        // database/migrations/xxxx_create_training_sessions_table.php
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            // Relazione polimorfica (collega a agents o employees)
            $table->morphs('trainee');

            $table->string('course_name');
            $table->string('provider'); // Ente erogatore (es. OAM, Associazione)
            $table->integer('hours'); // Ore del corso
            $table->date('completion_date');
            $table->date('expiry_date')->nullable(); // Utile per scadenze biennali
            $table->string('certificate_path')->nullable(); // PDF del certificato

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};
