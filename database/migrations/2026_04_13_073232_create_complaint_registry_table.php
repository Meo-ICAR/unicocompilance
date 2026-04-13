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
        Schema::create('complaint_registry', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id');
            $table->string('complaint_number', 50)->unique();
            $table->string('complainant_name', 255);
            $table->string('category', 50)->comment('Enum: delay, behavior, privacy, fraud');
            $table->text('description');
            $table->decimal('financial_impact', 10, 2)->default(0.0);
            $table->string('status', 30)->comment('Enum: open, investigating, resolved, rejected');
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->softUserstamps();

            $table->index('company_id', 'idx_complaint_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_registry');
    }
};
