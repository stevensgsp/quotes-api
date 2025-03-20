<?php

namespace Stevensgsp\QuotesApi\Tests\Feature;

use Stevensgsp\QuotesApi\Tests\TestCase;

/**
 * QuotesApiTest handles testing of the Quotes API endpoints.
 *
 * This test ensures that the Quotes API is responding correctly for the
 * defined routes.
 *
 * @author Steven Sucre <steven.g.s.p@gmail.com>
 * @version March 20, 2025
 */
class QuotesApiTest extends TestCase
{
    public function test_my_package_endpoint()
    {
        $response = $this->get('/api/quotes');

        $response->assertStatus(200);
    }
}
