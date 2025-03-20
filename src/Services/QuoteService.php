<?

namespace Stevensgsp\QuotesApi\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class QuoteService
{
    private string $apiBaseUrl;
    private int $rateLimit;
    private int $windowTime;

    public function __construct()
    {
        $this->apiBaseUrl = config('quotes.api_base', 'https://dummyjson.com');
        $this->rateLimit = config('quotes.rate_limit', 10);
        $this->windowTime = config('quotes.window_time', 60);
    }

    public function getAllQuotes()
    {
        return Cache::remember('quotes_all', $this->windowTime, function () {
            return Http::get("{$this->apiBaseUrl}/quotes")->json();
        });
    }

    public function getRandomQuote()
    {
        return Http::get("{$this->apiBaseUrl}/quotes/random")->json();
    }

    public function getQuote(int $id)
    {
        $quotes = $this->getAllQuotes();
        $index = $this->binarySearch($quotes, $id);
        return $index !== -1 ? $quotes[$index] : Http::get("{$this->apiBaseUrl}/quotes/{$id}")->json();
    }

    private function binarySearch(array $quotes, int $id)
    {
        $low = 0;
        $high = count($quotes) - 1;

        while ($low <= $high) {
            $mid = (int) (($low + $high) / 2);
            if ($quotes[$mid]['id'] == $id) return $mid;
            $quotes[$mid]['id'] < $id ? $low = $mid + 1 : $high = $mid - 1;
        }

        return -1;
    }
}