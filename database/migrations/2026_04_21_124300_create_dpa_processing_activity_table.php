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
        Schema::create('dpa_processing_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dpa_id');
            $table->unsignedBigInteger('processing_activity_id');
            $table->text('specific_instructions')->nullable();
            $table->timestamps();

            $table->unique(['dpa_id', 'processing_activity_id']);
            $table->foreign('dpa_id')->references('id')->on('dpas')->onDelete('cascade');
            $table->foreign('processing_activity_id')->references('id')->on('processing_activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpa_processing_activity');
    }
};
