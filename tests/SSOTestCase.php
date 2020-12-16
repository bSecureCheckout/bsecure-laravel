<?php

namespace bSecure\UniversalCheckout\Tests;

use bSecure\UniversalCheckout\SSOServiceProvider;

class SSOTestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
          SSOServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}