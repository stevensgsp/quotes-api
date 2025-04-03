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
    public function test_fetch_all_quotes()
    {
        $response = $this->get('/api/quotes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'quotes' => [
                '*' => ['id', 'quote', 'author'],
            ],
        ]);
    }

    public function test_fetch_random_quote()
    {
        $response = $this->get('/api/quotes/random');

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'quote', 'author']);
    }

    public function test_fetch_specific_quote()
    {
        $response = $this->get('/api/quotes/1');

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'quote', 'author']);
    }

    public function test_fetch_non_existent_quote_returns_404()
    {
        $response = $this->get('/api/quotes/999999');

        $response->assertStatus(404);
    }
}
