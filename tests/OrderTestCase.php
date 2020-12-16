<?php

namespace bSecure\UniversalCheckout\Tests;

use bSecure\UniversalCheckout\CheckoutServiceProvider;

class OrderTestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
          CheckoutServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}