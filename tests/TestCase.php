<?php

namespace Tests;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        // Disable CSRF verification for all tests — Fortify's POST routes use
        // the 'web' middleware group which includes CSRF, causing 419s in tests.
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }
}
