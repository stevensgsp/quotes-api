<template>
    <div class="max-w-2xl mx-auto p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Get Quote by ID</h2>

        <div class="flex items-center space-x-2">
            <input 
                v-model="quoteId"
                type="number"
                placeholder="Enter Quote ID"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none"
            />
            <button 
                @click="fetchQuoteById"
                class="px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="!quoteId"
            >Get Quote</button>
        </div>

        <div v-if="quoteById" class="mt-6 p-6 bg-white shadow-lg rounded-lg border border-gray-200">
            <p class="text-lg font-medium text-gray-700">"{{ quoteById.quote }}"</p>
            <p class="text-right text-gray-500 mt-2">- {{ quoteById.author }}</p>
        </div>

        <p v-if="errorMessage" class="mt-4 text-red-500 text-center">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            quoteId: '',
            quoteById: null,
            errorMessage: '',
        };
    },
    methods: {
        async fetchQuoteById() {
            if (!this.quoteId) return;

            this.quoteById = null;
            this.errorMessage = '';

            try {
                let response = await axios.get(`/api/quotes/${this.quoteId}`);
                this.quoteById = response.data;
            } catch (error) {
                this.errorMessage = "Quote not found or invalid ID.";
            }
        },
    },
};
</script>
