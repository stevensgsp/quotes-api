<template>
    <div>
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
            quoteId: '',
            quoteById: null,
        };
    },
    methods: {
        async fetchQuoteById() {
            if (!this.quoteId) return;
            let response = await axios.get(`/api/quotes/${this.quoteId}`);
            this.quoteById = response.data;
        },
    },
};
</script>