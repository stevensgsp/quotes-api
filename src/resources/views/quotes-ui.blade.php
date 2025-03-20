<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes UI</title>
</head>
<body>
    <div id="app">
        <h1>Quotes UI</h1>

        <div v-if="quotes.length">
            <h2>All Quotes</h2>
            <div v-for="quote in quotes" :key="quote.id">
                <p>@{{ quote.quote }} - @{{ quote.author }}</p>
            </div>

            <div v-if="totalPages > 1">
                <button @click="fetchNextPageQuotes" :disabled="currentPage >= totalPages">
                    Load More Quotes
                </button>
                <p>Page @{{ currentPage }} of @{{ totalPages }}</p>
            </div>
        </div>

        <h2>Random Quote</h2>
        <button @click="fetchRandomQuote">Get Random Quote</button>
        <p v-if="quote">@{{ quote.quote }} - @{{ quote.author }}</p>

        <h2>Get Quote by ID</h2>
        <input v-model="quoteId" placeholder="Enter Quote ID" />
        <button @click="fetchQuoteById">Get Quote</button>
        <p v-if="quoteById">@{{ quoteById.quote }} - @{{ quoteById.author }}</p>
    </div>

    <script type="module" src="{{ asset('vendor/quotes-api/assets/index.js') }}"></script>
</body>
</html>
