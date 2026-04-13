<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Redirect cross-database connections to SQLite in-memory for testing
        config([
            'database.connections.bpm' => [
                'driver'                  => 'sqlite',
                'database'                => ':memory:',
                'prefix'                  => '',
                'foreign_key_constraints' => false,
            ],
            'database.connections.mysql_compliance' => [
                'driver'                  => 'sqlite',
                'database'                => ':memory:',
                'prefix'                  => '',
                'foreign_key_constraints' => false,
            ],
        ]);

        $this->createBpmTables();
    }

    /**
     * Create the BPM tables needed for testing (normally live in db_bpm).
     */
    protected function createBpmTables(): void
    {
        $bpm = Schema::connection('bpm');

        if (! $bpm->hasTable('companies')) {
            $bpm->create('companies', function ($table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('domain')->nullable();
                $table->string('vat_number')->nullable();
                $table->string('vat_name')->nullable();
                $table->timestamps();
            });
        }

        if (! $bpm->hasTable('users')) {
            $bpm->create('users', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->boolean('is_approved')->default(false);
                $table->boolean('is_super_admin')->default(false);
                $table->string('avatar_url')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (! $bpm->hasTable('company_user')) {
            $bpm->create('company_user', function ($table) {
                $table->id();
                $table->uuid('company_id');
                $table->unsignedBigInteger('user_id');
                $table->string('role')->nullable();
                $table->timestamps();
            });
        }
    }
}
