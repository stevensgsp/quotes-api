<?php

namespace Stevensgsp\QuotesApi\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

/**
 * This service provides methods to fetch all quotes, a random quote, and
 * a specific quote by its ID. It also manages rate limiting, caching,
 * and binary search to efficiently handle large sets of quotes.
 *
 * @author Steven Sucre <steven.g.s.p@gmail.com>
 * @version March 20, 2025
 */
class QuoteService
{
    private string $apiBaseUrl;
    private int $rateLimit;
    private int $windowTime;
    private int $cacheTime;
    private array $localCache = [];

    public function __construct()
    {
        $this->apiBaseUrl = config('quotes.base_url', 'https://dummyjson.com');
        $this->rateLimit = config('quotes.rate_limit', 60);
        $this->windowTime = config('quotes.window_time', 60);
        $this->cacheTime = config('quotes.cache_time', 3600);
    }

    /**
     * Fetch all quotes with optional pagination parameters.
     *
     * @param int $limit Number of quotes to retrieve.
     * @param int $skip Number of quotes to skip (for pagination).
     * @return array Cached or freshly fetched quotes.
     */
    public function getAllQuotes(int $limit = 0, int $skip = 0)
    {
        // First, try to recover from the local cache
        if (! empty($this->localCache)) {
            return $this->localCache;
        }

        // Then, check in the global cache
        if (Cache::has($cacheKey = "quotes_{$limit}_{$skip}")) {
            $this->localCache = Cache::get($cacheKey);

            return $this->localCache;
        }

        // Finally, fetch from API and store in cache
        return $this->fetchAndCacheQuotes($limit, $skip);
    }

    /**
     * Fetch and cache quotes from the API.
     *
     * @param int $limit Number of quotes to retrieve.
     * @param int $skip Number of quotes to skip (for pagination).
     * @return array The quotes data after fetching from the API and caching it.
     */
    private function fetchAndCacheQuotes(int $limit, int $skip)
    {
        // Get API quotes with limit and skip
        $url = "{$this->apiBaseUrl}/quotes?limit={$limit}&skip={$skip}";

        // Retrieve quotes and store them in the cache
        $response = $this->makeRequest($url);

        // Ensure quotes are sorted by ID for binary search
        usort($response['quotes'], fn($a, $b) => $a['id'] <=> $b['id']);

        // Caching quotes
        $this->localCache = $response;
        Cache::remember("quotes_{$limit}_{$skip}", $this->cacheTime, function () use ($response) {
            return $response;
        });

        return $this->localCache;
    }

    /**
     * Fetch a random quote from the API.
     *
     * @return array The random quote data.
     */
    public function getRandomQuote()
    {
        return $this->makeRequest("{$this->apiBaseUrl}/quotes/random");
    }

    /**
     * Fetch a specific quote by its ID.
     *
     * @param int $id The ID of the quote to retrieve.
     * @return array The quote data, either from the cache or fresh from the API.
     */
    public function getQuote(int $id)
    {
        // We check if the quote is in the local cache
        $quotesData = $this->getAllQuotes();
        $quotes = $quotesData['quotes'] ?? [];

        if (empty($quotes)) {
            return [];
        }

        $index = $this->binarySearch($quotes, $id);

        if ($index !== -1) {
            return $quotes[$index];
        }

        // If it is not in the cache, we request it from the API
        $quote = $this->makeRequest("{$this->apiBaseUrl}/quotes/{$id}");

        if (! isset($quote['id'])) {
            return [];
        }

        // We add the new quote to the local cache and sort the cache
        $this->addQuoteToCache($quote);

        return $quote;
    }

    /**
     * Make an HTTP request to the given URL.
     *
     * @param string $url The URL to send the request to.
     * @return array The response data from the API.
     */
    private function makeRequest(string $url): array
    {
        Log::debug("Requesting: $url");

        $rateLimitKey = 'quotes_api:' . request()->ip();

        while (RateLimiter::tooManyAttempts($rateLimitKey, $this->rateLimit)) {
            Log::debug('Rate limit reached. Waiting before retrying...');

            sleep(2);
        }

        RateLimiter::hit($rateLimitKey, $this->windowTime);

        return Http::get($url)->json();
    }

    /**
     * Perform a binary search on the quotes array to find the quote by ID.
     *
     * @param array $quotes The array of quotes to search through.
     * @param int $id The ID of the quote to find.
     * @return int The index of the quote in the array, or -1 if not found.
     */
    private function binarySearch(array $quotes, int $id)
    {
        $low = 0;
        $high = count($quotes) - 1;

        while ($low <= $high) {
            $mid = (int) (($low + $high) / 2);

            if ($quotes[$mid]['id'] == $id) {
                return $mid;
            }

            $quotes[$mid]['id'] < $id ? $low = $mid + 1 : $high = $mid - 1;
        }

        return -1;
    }

    /**
     * Add a quote to the local cache and sort the cache by ID.
     *
     * @param array $quote The quote to add to the cache.
     * @return void
     */
    private function addQuoteToCache(array $quote)
    {
        // If the quote is already in the local cache, we don't add it.
        if (in_array($quote, $this->localCache)) {
            return;
        }

        $this->localCache[] = $quote;

        // We sort the local cache by ID to ensure that binary search works.
        usort($this->localCache, fn($a, $b) => $a['id'] <=> $b['id']);
    }
}
