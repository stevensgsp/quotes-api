<?php

use Illuminate\Support\Facades\Route;
use Stevensgsp\QuotesApi\Http\Controllers\QuoteController;

Route::prefix('api/quotes')->group(function () {
    Route::get('/', [QuoteController::class, 'index']);
    Route::get('/random', [QuoteController::class, 'random']);
    Route::get('/{id}', [QuoteController::class, 'show']);
    Route::get('/next', [QuoteController::class, 'nextPage']);
    Route::get('/total-pages', [QuoteController::class, 'totalPages']);
});
