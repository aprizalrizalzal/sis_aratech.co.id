<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const footers = usePage().props.footers;

const contactFooters = computed(() => {
    return footers.filter(footer => footer.type === 'Contact');
});

const socialMediaFooters = computed(() => {
    return footers.filter(footer => footer.type === 'Social Media');
});

const appDownloadFooters = computed(() => {
    return footers.filter(footer => footer.type === 'App Download');
});
</script>

<template>
    <div class="flex flex-col items-center">
        <div v-for="header in $page.props.headers" :key="header.id" class="w-full max-w-2xl px-6 lg:max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 mt-8 pb-8 mx-4 items-start gap-2">
                <div class="text-start">
                    <ApplicationLogo class="block h-16 w-16" />
                    <h2 class="text-xl font-semibold text-green-900">{{ header.company }}</h2>
                    <p class=" mt-4">{{ header.description }}</p>
                </div>
                <div class="mt-8 px-2 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">Contact</h2>
                    <ul class="mt-4 text-sm/relaxed">
                        <li v-for="footer in contactFooters" :key="footer.id" class="flex items-center space-x-2 mt-2">
                            {{ footer.platform }}: <a :href="footer.url" target="_blank" rel="noopener noreferrer">{{
                                footer.username }}</a>
                        </li>
                    </ul>
                </div>
                <div class="mt-8 px-2 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">Social Media</h2>
                    <ul class="mt-4 text-sm/relaxed">
                        <li v-for="footer in socialMediaFooters" :key="footer.id" class="flex items-center space-x-2">
                            {{ footer.platform }}: <a :href="footer.url" target="_blank" rel="noopener noreferrer">{{
                                footer.username }}</a>
                        </li>
                    </ul>
                </div>
                <div class="mt-8 px-2 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">Download</h2>
                    <div class="w-full rounded-md mt-4">
                        <p class=" mt-4">Dapatkan pengalaman service yang lebih baik! Unduh aplikasi kami sekarang di
                            Play Store dan
                            App Store.</p>
                    </div>
                    <ul class="mt-4 text-sm/relaxed">
                        <li v-for="footer in appDownloadFooters" :key="footer.id" class="flex items-center space-x-2">
                            {{ footer.platform }}: <a :href="footer.url" target="_blank" rel="noopener noreferrer">{{
                                footer.username }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <p class="relative">{{ header.company }} &copy;2024</p>
        </div>
    </div>
</template>