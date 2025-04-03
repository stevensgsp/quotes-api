<template>
    <div class="min-h-screen bg-gray-100">
        <aside class="bg-blue-600 text-white p-4 space-y-4 w-full">
            <div class="flex justify-between items-center max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold">
                    <router-link to="/">Quotes App</router-link>
                </h1>
                <nav class="flex gap-3 justify-center items-center">
                    <router-link
                        to="/"
                        class="block px-4 py-2 rounded-lg hover:bg-blue-500"
                        :class="{ 'bg-blue-500': route.path === '/' }"
                    >List</router-link>

                    <router-link
                        to="/get-by-id"
                        class="block px-4 py-2 rounded-lg hover:bg-blue-500"
                        :class="{ 'bg-blue-500': route.path === '/get-by-id' }"
                    >Get By Id</router-link>

                    <router-link
                        to="/random"
                        class="block px-4 py-2 rounded-lg hover:bg-blue-500"
                        :class="{ 'bg-blue-500': route.path === '/random' }"
                    >Random</router-link>
                </nav>
            </div>
        </aside>

        <main>
            <router-view></router-view>
        </main>
    </div>
</template>


<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();
</script>
