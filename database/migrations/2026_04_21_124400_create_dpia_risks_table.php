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
        Schema::create('dpia_risks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dpia_id');
            $table->string('risk_type');
            $table->text('description');
            $table->unsignedTinyInteger('initial_probability')->nullable();
            $table->unsignedTinyInteger('initial_severity')->nullable();
            $table->unsignedTinyInteger('initial_score')->nullable();
            $table->text('mitigation_measures')->nullable();
            $table->unsignedTinyInteger('residual_probability')->nullable();
            $table->unsignedTinyInteger('residual_severity')->nullable();
            $table->unsignedTinyInteger('residual_score')->nullable();
            $table->timestamps();

            $table->foreign('dpia_id')->references('id')->on('dpias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpia_risks');
    }
};
