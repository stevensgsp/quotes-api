<template>
    <div>
        <h2>Random Quote</h2>

        <button @click="fetchRandomQuote">Get Random Quote</button>
        <p v-if="quote">{{ quote.quote }} - {{ quote.author }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            quote: null,
        };
    },
    methods: {
        async fetchRandomQuote() {
            let response = await axios.get('/api/quotes/random');
            this.quote = response.data;
        },
    },
};
</script>
