<template>
    <div>
        <h2>All Quotes</h2>
        <div v-for="quote in quotes" :key="quote.id">
            <p>{{ quote.quote }} - {{ quote.author }}</p>
        </div>

        <div v-if="totalPages > 1">
            <button
                v-for="page in totalPages"
                :key="page"
                @click="fetchQuotes(page)"
                :class="{ active: page === currentPage }"
            >
                {{ page }}
            </button>
        </div>

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
            perPage: 10,
        };
    },
    methods: {
        async fetchRandomQuote() {
            let response = await axios.get('/api/quotes/random');
            this.quote = response.data;
        },
        async fetchQuotes(page = 1) {
            let response = await axios.get(`/api/quotes?page=${page}&perPage=${perPage}`);
            this.quotes = response.data.quotes;
            this.totalPages = Math.ceil(response.data.total / this.perPage);
            this.currentPage = page;
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

<style scoped>
button {
    margin: 5px;
    padding: 5px 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    background-color: #f9f9f9;
}

button.active {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}
</style>
