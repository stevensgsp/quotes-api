<template>
    <div>
        <h2>All Quotes</h2>

        <div v-for="quote in quotes" :key="quote.id">
            <p>{{ quote.quote }} - {{ quote.author }}</p>
        </div>

        <div v-if="totalPages > 1" class="pagination">
            <button @click="fetchQuotes(currentPage - 1)" :disabled="currentPage === 1">
                Prev
            </button>

            <template v-for="page in visiblePages" :key="page">
                <button
                    v-if="page === '...'"
                    disabled
                    class="dots">
                    ...
                </button>
                <button
                    v-else
                    @click="fetchQuotes(page)"
                    :class="{ active: currentPage === page }">
                    {{ page }}
                </button>
            </template>

            <button @click="fetchQuotes(currentPage + 1)" :disabled="currentPage === totalPages">
                Next
            </button>
        </div>

        <p>Page {{ currentPage }} of {{ totalPages }}</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
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
