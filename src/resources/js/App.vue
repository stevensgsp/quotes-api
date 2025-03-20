<template>
    <div>
        <!-- Ver todas las citas con paginación -->
        <h2>All Quotes</h2>
        <div v-for="quote in quotes" :key="quote.id">
            <p>{{ quote.quote }} - {{ quote.author }}</p>
        </div>
        <button @click="fetchQuotes">Load More Quotes</button>

        <!-- Ver una cita aleatoria -->
        <h2>Random Quote</h2>
        <button @click="fetchRandomQuote">Get Random Quote</button>
        <p v-if="quote">{{ quote.quote }} - {{ quote.author }}</p>

        <!-- Ver una cita específica por ID -->
        <h2>Get Quote by ID</h2>
        <input v-model="quoteId" placeholder="Enter Quote ID" />
        <button @click="fetchQuoteById">Get Quote</button>
        <p v-if="quoteById">{{ quoteById.quote }} - {{ quoteById.author }}</p>
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
            page: 1,
        };
    },
    methods: {
        async fetchRandomQuote() {
            let response = await axios.get('/api/quotes/random');
            this.quote = response.data;
        },

        async fetchQuotes() {
            let response = await axios.get(`/api/quotes?page=${this.page}`);
            this.quotes = [...this.quotes, ...response.data.data];
            this.page += 1;
        },

        async fetchQuoteById() {
            if (!this.quoteId) return;
            let response = await axios.get(`/api/quotes/${this.quoteId}`);
            this.quoteById = response.data;
        },
    },
    mounted() {
        this.fetchQuotes();
    },
};
</script>
