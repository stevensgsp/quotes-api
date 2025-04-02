<template>
    <div class="flex min-h-screen bg-gray-100">
        <aside class="w-64 bg-blue-600 text-white p-4 space-y-4">
            <h1 class="text-2xl font-bold">Quotes App</h1>
            <nav class="space-y-2">
                <router-link to="/" class="block px-4 py-2 rounded-lg hover:bg-blue-500">List</router-link>
                <router-link to="/get-by-id" class="block px-4 py-2 rounded-lg hover:bg-blue-500">Get By Id</router-link>
                <router-link to="/random" class="block px-4 py-2 rounded-lg hover:bg-blue-500">Random</router-link>
            </nav>
        </aside>

        <main class="flex-1 p-6">
            <router-view></router-view>
        </main>
    </div>
</template>
