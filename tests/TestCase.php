<?php

namespace Tests;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }
}
