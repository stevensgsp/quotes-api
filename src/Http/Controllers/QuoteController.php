<?php

namespace Stevensgsp\QuotesApi\Http\Controllers;

use Illuminate\Http\Request;
use Stevensgsp\QuotesApi\Services\QuoteService;

class QuoteController
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function index(Request $request)
    {
        $page = $request->query('page', 1);

        $limit = $request->query('perPage', 10);
        $skip = ($page - 1) * $limit;

        return response()->json($this->quoteService->getAllQuotes($limit, $skip));
    }

    public function random()
    {
        return response()->json($this->quoteService->getRandomQuote());
    }

    public function show($id)
    {
        return response()->json($this->quoteService->getQuote($id));
    }

    public function totalPages()
    {
        return response()->json(['total_pages' => $this->quoteService->getTotalPages()]);
    }
}
