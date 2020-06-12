<?php

namespace OnzaMe\JWT\Tests;

use Orchestra\Testbench\TestCase;
use OnzaMe\JWT\JWTServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [JWTServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
