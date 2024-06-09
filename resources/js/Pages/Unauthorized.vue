<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Unauthorized" />
    <div class="flex flex-col justify-center items-center h-screen bg-gray-100">
        <div class="text-center">
            <h1 class="mb-4 text-6xl font-semibold text-red-500">404</h1>
            <p class="mb-4 text-lg text-gray-600">Oops! Looks like you're lost.</p>
            <div class="animate-bounce">
                <svg class="mx-auto h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </div>
            <p class="mt-4 text-gray-600">Let's get you back </p>
            <Link :href="route('show.welcome')"
                class="mt-8 inline-block bg-red-700 text-white py-2 px-4 rounded hover:bg-red-500 transition duration-300">
            Kembali ke Beranda
            </Link>.
        </div>
    </div>
</template>
