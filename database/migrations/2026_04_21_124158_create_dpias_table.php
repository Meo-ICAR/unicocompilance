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
        Schema::create('dpias', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id');
            $table->string('process_name');
            $table->text('process_description');
            $table->json('necessity_assessment');
            $table->text('dpo_advice')->nullable();
            $table->timestamp('dpo_reviewed_at')->nullable();
            $table->string('status');
            $table->date('next_review_date')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index('next_review_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpias');
    }
};
