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
        Schema::create('client_dpas', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->default(0);
            $table->string('name', 255);
            $table->string('status', 255);
            $table->text('processing_nature_and_purpose');
            $table->json('data_categories');
            $table->json('data_subjects');
            $table->boolean('allows_general_subprocessors')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('model_id', 255);
            $table->string('model_type', 255);
            $table->uuid('company_id');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->primary('id');
            $table->index(['company_id', 'status']);
            $table->index(['model_type', 'model_id']);
            $table->index('valid_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_dpas');
    }
};
