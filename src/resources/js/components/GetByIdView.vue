<template>
    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Quote by ID</h2>

        <div class="flex items-center space-x-2">
            <input
                v-model="quoteId"
                type="number"
                placeholder="Enter Quote ID"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none"
            />
            <button
                @click="fetchQuoteById"
                class="px-4 py-3 bg-blue-500 border border-blue-500 text-white rounded-lg hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed text-nowrap"
                :disabled="!quoteId"
            >Get Quote</button>
        </div>

        <quote-card v-if="Object.values(quote).length > 0" :quote="quote" />

        <p v-if="errorMessage" class="mt-4 text-red-500 text-center">{{ errorMessage }}</p>
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
            quoteId: '',
            quote: {},
            errorMessage: '',
        };
    },
    mounted() {
        if (this.$route.params.id) {
            this.quoteId = this.$route.params.id;
            this.fetchQuoteById();
        }
    },
    methods: {
        async fetchQuoteById() {
            if (!this.quoteId) return;

            this.quote = {};
            this.errorMessage = '';

            try {
                let response = await axios.get(`/api/quotes/${this.quoteId}`);
                this.quote = response.data;
            } catch (error) {
                this.errorMessage = "Quote not found or invalid ID.";
            }
        },
    },
};
</script>
