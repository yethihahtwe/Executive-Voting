<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

trait DatabaseSetup
{
    use RefreshDatabase;

    /**
     * Setup the in-memory database connection.
     */
    public function setupDatabase()
    {
        // Force SQLite to use foreign keys
        DB::statement('PRAGMA foreign_keys = ON');

        // Run migrations
        Artisan::call('migrate');
        
        // Register custom view path for testing
        View::addLocation(__DIR__ . '/views');
    }

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupDatabase();
    }
}
