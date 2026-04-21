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
        Schema::connection('mysql_compliance')->create('client_dpas', function (Blueprint $table) {
            $table->id();
            $table->uuid('company_id');
            $table->string('name');
            $table->string('status');
            $table->text('processing_nature_and_purpose');
            $table->json('data_categories');
            $table->json('data_subjects');
            $table->boolean('allows_general_subprocessors')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->date('valid_until')->nullable();
            $table->nullableMorphs('model');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'status']);
            $table->index('valid_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_compliance')->dropIfExists('client_dpas');
    }
};
