<template>
    <div class="mt-6 p-6 bg-white shadow-md hover:shadow-lg rounded-lg border border-gray-200 hover:-translate-y-3 transition">
        <p class="text-lg font-medium text-gray-700">"{{ quote.quote }}"</p>

        <div class="flex justify-between items-center w-full mt-2">
            <router-link
                v-if="showSeeMore"
                :to="`/get-by-id/${quote.id}`"
                class="block py-2 rounded-lg text-blue-500 hover:text-blue-600 text-nowrap"
            >See more...</router-link>

            <p class="text-right text-gray-500 mb-0 w-full">- {{ quote.author }}</p>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        quote: {
            type: Object,
            required: true,
        },
        showSeeMore: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
