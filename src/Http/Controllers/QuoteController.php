<?

namespace Stevensgsp\QuotesApi\Http\Controllers;

use Stevensgsp\QuotesApi\Services\QuoteService;
use Illuminate\Http\Request;

class QuoteController
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function index()
    {
        return response()->json($this->quoteService->getAllQuotes());
    }

    public function random()
    {
        return response()->json($this->quoteService->getRandomQuote());
    }

    public function show($id)
    {
        return response()->json($this->quoteService->getQuote($id));
    }
}
