<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Unauthorized" />
    <div class="flex flex-col justify-center items-center h-screen bg-gray-100">
        <div class="text-center">
            <h1 class="mb-4 text-6xl font-semibold text-green-800 animate-ping">404</h1>
            <p class="mb-4 text-lg text-gray-600">Oops! Looks like you're lost.</p>
            <div class="animate-pulse">
                <ApplicationLogo class="inline-block h-64 w-64 fill-current p-4" />
            </div>
            <p class="text-gray-600">Let's get you back </p>
            <Link :href="route('show.welcome')"
                class="mt-8 inline-block bg-green-800 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-150">
            Return to Home
            </Link>.
        </div>
    </div>
</template>
