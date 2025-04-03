<template>
    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Random Quote</h2>

        <div class="flex justify-center">
            <button
                @click="fetchRandomQuote"
                class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="loading">
                {{ loading ? "Loading..." : "Get Random Quote" }}
            </button>
        </div>

        <quote-card v-if="Object.values(quote).length > 0" :quote="quote" />

        <p v-else class="mt-6 text-gray-500 text-center">Click the button to get a random quote!</p>
    </div>
</template>

<script>
import axios from 'axios';
import QuoteCard from './QuoteCard.vue';

export default {
    components: {
        QuoteCard,
    },
    data() {
        return {
            quote: {},
            loading: false,
        };
    },
    methods: {
        async fetchRandomQuote() {
            this.loading = true;
            try {
                let response = await axios.get('/api/quotes/random');
                this.quote = response.data;
            } catch (error) {
                console.error("Error fetching quote:", error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
