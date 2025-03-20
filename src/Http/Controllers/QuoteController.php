<?php

namespace Stevensgsp\QuotesApi\Http\Controllers;

use Illuminate\Http\Request;
use Stevensgsp\QuotesApi\Services\QuoteService;

/**
 * This controller provides methods for retrieving a list of quotes, a random
 * quote, and a specific quote by its ID. It interacts with the QuoteService
 * to fetch the required data and return the response in JSON format.
 *
 * @author Steven Sucre <steven.g.s.p@gmail.com>
 * @version March 20, 2025
 */
class QuoteController
{
    /**
     * @var \Stevensgsp\QuotesApi\Services\QuoteService
     */
    protected $quoteService;

    /**
     * @param \Stevensgsp\QuotesApi\Services\QuoteService $quoteService
     */
    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    /**
     * Display a paginated list of all quotes.
     *
     * This method retrieves all quotes from the QuoteService and returns them
     * as a paginated JSON response. You can specify the page and perPage
     * parameters via query strings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);

        $limit = $request->query('perPage', 10);
        $skip = ($page - 1) * $limit;

        return response()->json($this->quoteService->getAllQuotes($limit, $skip));
    }

    /**
     * This method retrieves a random quote from the QuoteService and returns
     * it as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function random()
    {
        return response()->json($this->quoteService->getRandomQuote());
    }

    /**
     * This method retrieves a single quote by its ID from the QuoteService
     * and returns it as a JSON response.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json($this->quoteService->getQuote($id));
    }
}
