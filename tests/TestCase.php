<?php

namespace Stevensgsp\QuotesApi\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Stevensgsp\QuotesApi\Providers\QuotesApiServiceProvider;

/**
 * TestCase serves as the base test class for the Quotes API package.
 *
 * This class extends Orchestra's base TestCase to provide a convenient
 * setup for testing the package. It includes the registration of the
 * QuotesApiServiceProvider to make the package's functionality available
 * during tests.
 *
 * @author Steven Sucre <steven.g.s.p@gmail.com>
 * @version March 20, 2025
 */
class TestCase extends BaseTestCase
{
    /**
     * Get the package providers that are needed for testing.
     *
     * This method registers the QuotesApiServiceProvider, making the
     * functionality of the Quotes API package available to the test cases.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            QuotesApiServiceProvider::class,
        ];
    }
}
