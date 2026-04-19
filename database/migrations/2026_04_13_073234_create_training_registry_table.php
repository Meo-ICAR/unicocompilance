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
        Schema::create('training_registry', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id')->comment('Logical FK: db_bpm.companies');
            $table->unsignedBigInteger('user_id')->comment('Logical FK: db_bpm.users');
            $table->string('course_name', 255);
            $table->string('regulatory_framework', 50)->comment('Enum: ivass, oam, gdpr, safety');
            $table->date('completed_at');
            $table->date('valid_until')->nullable();
            $table->uuid('certificate_document_id')->nullable()->comment('Logical FK: db_unicodoc.documents');
            $table->timestamps();
            $table->softDeletes();

            //  $table->index('user_id', 'idx_training_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_registry');
    }
};
