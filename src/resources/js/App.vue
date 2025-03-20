<template>
    <div>
        <h2>All Quotes</h2>
        <div v-for="quote in quotes" :key="quote.id">
            <p>{{ quote.quote }} - {{ quote.author }}</p>
        </div>
        <button @click="fetchNextPageQuotes" :disabled="currentPage >= totalPages">
            Load More Quotes
        </button>

        <h2>Random Quote</h2>
        <button @click="fetchRandomQuote">Get Random Quote</button>
        <p v-if="quote">{{ quote.quote }} - {{ quote.author }}</p>

        <h2>Get Quote by ID</h2>
        <input v-model="quoteId" placeholder="Enter Quote ID" />
        <button @click="fetchQuoteById">Get Quote</button>
        <p v-if="quoteById">{{ quoteById.quote }} - {{ quoteById.author }}</p>

        <p>Page {{ currentPage }} of {{ totalPages }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            quote: null,
            quoteId: '',
            quotes: [],
            quoteById: null,
            currentPage: 1,
            totalPages: 0,
        };
    },
    methods: {
        async fetchRandomQuote() {
            let response = await axios.get('/api/quotes/random');
            this.quote = response.data;
        },
        async fetchNextPageQuotes() {
            let response = await axios.get('/api/quotes');
            this.quotes = [...this.quotes, ...response.data];
            this.currentPage++;
        },
        async fetchQuoteById() {
            if (!this.quoteId) return;
            let response = await axios.get(`/api/quotes/${this.quoteId}`);
            this.quoteById = response.data;
        },
        async fetchTotalPages() {
            let response = await axios.get('/api/quotes/total-pages');
            this.totalPages = response.data.total_pages;
        },
    },
    mounted() {
        this.fetchNextPageQuotes();
        this.fetchTotalPages();
    },
};
</script>
