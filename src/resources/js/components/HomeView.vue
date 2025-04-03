<template>
    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">All Quotes</h2>

        <div v-if="quotes.length > 0" class="space-y-4">
            <div
                v-for="quote in quotes"
                :key="quote.id"
            >
                <quote-card :quote="quote" :show-see-more="true" />
            </div>
        </div>

        <div v-if="totalPages > 1" class="flex justify-center mt-6">
            <button
                @click="fetchQuotes(currentPage - 1)"
                :disabled="currentPage === 1"
                class="px-4 py-2 mx-1 bg-gray-300 text-gray-700 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
            >Prev</button>

            <template v-for="page in visiblePages" :key="page">
                <button
                    v-if="page === '...'"
                    disabled
                    class="px-4 py-2 mx-1 text-gray-500 cursor-default">
                    ...
                </button>
                <button
                    v-else
                    @click="fetchQuotes(page)"
                    :class="['px-4 py-2 mx-1 rounded-lg', currentPage === page ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-700']">
                    {{ page }}
                </button>
            </template>

            <button
                @click="fetchQuotes(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="px-4 py-2 mx-1 bg-gray-300 text-gray-700 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
                Next
            </button>
        </div>

        <p class="text-center text-gray-600 mt-4">Page {{ currentPage }} of {{ totalPages }}</p>
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
            quotes: [],
            currentPage: 1,
            totalPages: 0,
            perPage: 10,
        };
    },
    computed: {
        visiblePages() {
            const range = [];
            const total = this.totalPages;
            const current = this.currentPage;
            const delta = 2; // How many buttons to display around the current page

            // If there are few pages, we show all of them
            if (total <= 7) {
                return Array.from({ length: total }, (_, i) => i + 1);
            }

            // Always show the first and last page
            range.push(1);
            if (current - delta > 2) {
                range.push("...");
            }

            for (let i = Math.max(2, current - delta); i <= Math.min(total - 1, current + delta); i++) {
                range.push(i);
            }

            if (current + delta < total - 1) {
                range.push("...");
            }

            range.push(total);
            return range;
        }
    },
    methods: {
        async fetchQuotes(page = 1) {
            this.currentPage = page;

            let response = await axios.get(`/api/quotes?page=${this.currentPage}&perPage=${this.perPage}`);

            this.quotes = response.data.quotes;
            this.totalPages = Math.ceil(response.data.total / this.perPage);
        },
    },
    mounted() {
        this.fetchQuotes();
    }
};
</script>
