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
        Schema::create('conflict_of_interest_registry', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Logical FK: db_bpm.users');
            $table->text('conflict_description');
            $table->text('mitigation_strategy')->nullable();
            $table->dateTime('approved_by_compliance_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->softUserstamps();

            $table->index('user_id', 'idx_conflict_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conflict_of_interest_registry');
    }
};
