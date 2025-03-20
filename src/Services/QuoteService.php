<?php

namespace Stevensgsp\QuotesApi\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class QuoteService
{
    private string $apiBaseUrl;
    private int $rateLimit;
    private int $windowTime;
    private string $cacheKey = 'quotes_api_request_count';

    public function __construct()
    {
        $this->apiBaseUrl = config('quotes.base_url', 'https://dummyjson.com');
        $this->rateLimit = config('quotes.rate_limit', 10);
        $this->windowTime = config('quotes.window_time', 60);
    }

    public function getAllQuotes()
    {
        return Cache::remember('quotes_all', $this->windowTime, function () {
            return $this->makeRequest("{$this->apiBaseUrl}/quotes");
        });
    }

    public function getRandomQuote()
    {
        return $this->makeRequest("{$this->apiBaseUrl}/quotes/random");
    }

    public function getQuote(int $id)
    {
        $quotes = $this->getAllQuotes();
        $index = $this->binarySearch($quotes, $id);
        return $index !== -1 ? $quotes[$index] : $this->makeRequest("{$this->apiBaseUrl}/quotes/{$id}");
    }

    private function makeRequest(string $url)
    {
        $this->enforceRateLimit();

        return Http::get($url)->json();
    }

    private function enforceRateLimit()
    {
        while (true) {
            $data = Cache::get($this->cacheKey);

            // If the cache does not exist, initialize it
            if (empty($data)) {
                $data = ['count' => 0, 'reset_at' => now()->timestamp + $this->windowTime];

                Cache::put($this->cacheKey, $data, $this->windowTime);
            }

            // If the window has already been reset, reset the counter
            if ($data['reset_at'] <= now()->timestamp) {
                Cache::put($this->cacheKey, ['count' => 1, 'reset_at' => now()->timestamp + $this->windowTime], $this->windowTime);

                return;
            }

            // If the limit has not been reached, increment the counter and continue
            if ($data['count'] < $this->rateLimit) {
                $data['count']++;

                Cache::put($this->cacheKey, $data, $this->windowTime);

                return;
            }

            // If the limit is reached, wait a short period before trying again.
            Log::warning("Rate limit reached. Waiting before retrying...");
            sleep(2);
        }
    }

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
}
