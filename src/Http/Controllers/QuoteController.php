<?php

namespace Stevensgsp\QuotesApi\Http\Controllers;

use Stevensgsp\QuotesApi\Services\QuoteService;

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

    public function nextPage()
    {
        return response()->json($this->quoteService->getNextPageQuotes());
    }

    public function totalPages()
    {
        return response()->json(['total_pages' => $this->quoteService->getTotalPages()]);
    }
}
