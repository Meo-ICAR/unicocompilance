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
        Schema::table('clienti_employees', function (Blueprint $table) {
            $table->dropColumn('personable_id');
            $table->uuid('personable_id')->nullable()->after('personable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clienti_employees', function (Blueprint $table) {
            $table->dropColumn('personable_id');
            $table->unsignedBigInteger('personable_id')->nullable()->after('personable_type');
        });
    }
};
