<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 pb-8 sm:pt-0 bg-gray-50">
        <div v-for="header in $page.props.headers" :key="header.id" class="pt-4">
            <Link href="/">
            <ApplicationLogo class="block w-32 h-32 fill-current text-green-600" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow overflow-hidden sm:rounded">
            <slot />
        </div>
    </div>
</template>
