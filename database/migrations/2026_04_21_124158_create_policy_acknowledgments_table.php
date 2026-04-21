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
        Schema::create('policy_acknowledgments', function (Blueprint $table) {
            $table->id();
            $table->string('policy_type')->nullable();
            $table->string('policy_id')->nullable();
            $table->string('policy_version_id', 50)->nullable();
            $table->timestamp('acknowledged_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['policy_type', 'policy_id']);
            $table->index('acknowledged_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_acknowledgments');
    }
};
