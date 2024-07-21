<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const footers = usePage().props.footers;

const contactFooters = computed(() => {
    return footers.filter(footer => footer.type_footer.type === 'Contact');
});

const getHref = (footer) => {
    if (footer.platform_footer.platform === 'Email') {
        return `mailto:${footer.value}`
    } else if (footer.platform_footer.platform === 'Phone') {
        return `tel:${footer.value}`
    } else {
        return footer.url
    }
}

const socialMediaFooters = computed(() => {
    return footers.filter(footer => footer.type_footer.type === 'Social Media');
});

const appDownloadFooters = computed(() => {
    return footers.filter(footer => footer.type_footer.type === 'App Download');
});

const currentYear = computed(() => {
    return new Date().getFullYear();
});
</script>

<template>
    <div class="flex flex-col items-center">
        <div v-for="header in $page.props.headers" :key="header.id" class="w-full max-w-2xl px-6 lg:max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 mt-8 pb-4 items-start gap-4">
                <div class="text-start">
                    <ApplicationLogo class="block h-16 w-16" />
                    <h2 class="text-xl font-semibold text-green-900">{{ header.company }}</h2>
                    <p class=" mt-4">{{ header.description }}</p>
                </div>
                <div class="lg:mt-8 md:mt-8 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">Contact</h2>
                    <ul class="mt-4 text-sm/relaxed">
                        <li v-for="footer in contactFooters" :key="footer.id" class="flex items-center space-x-2 mt-2">
                            <img :src="footer.image_path" :alt="footer.platform" class="w-4 h-auto">
                            <a :href="getHref(footer)" target="_blank" rel="noopener noreferrer">{{
                                footer.value }}</a>
                        </li>
                    </ul>
                </div>
                <div class="lg:mt-8 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">Social Media</h2>
                    <ul class="mt-4 text-sm/relaxed">
                        <li v-for="footer in socialMediaFooters" :key="footer.id" class="flex items-center space-x-2">
                            <img :src="footer.image_path" :alt="footer.platform" class="w-4 h-auto">
                            <a :href="footer.url" target="_blank" rel="noopener noreferrer">{{
                                footer.value }}</a>
                        </li>
                    </ul>
                </div>
                <div class="lg:mt-8 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">App Download</h2>
                    <div class="w-full rounded-sm mt-4">
                        <p class=" mt-4">Dapatkan pengalaman service yang lebih baik! Unduh aplikasi kami sekarang di
                            Play Store dan
                            App Store.</p>
                    </div>
                    <ul class="flex gap-2 mt-4 text-sm/relaxed">
                        <li v-for="footer in appDownloadFooters" :key="footer.id" class="flex items-center space-x-2">
                            <img :src="footer.image_path" :alt="footer.platform" class="w-4 h-auto">
                            <a :href="footer.url" target="_blank" rel="noopener noreferrer">{{
                                footer.value }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <p class="relative text-black">Copyright &copy; {{ currentYear }} <a href="https://aslimandiri.com"
                    target="_blank" rel="noopener noreferrer"><span class="text-green-900 font-bold">Asli Mandiri
                        Computer</span></a> Developed by <a href="https://www.linkedin.com/in/muhamad-aprizal-hardi/"
                    target="_blank" rel="noopener noreferrer"><span
                        class="text-green-900 font-bold">Technician</span></a> </p>
        </div>
    </div>
</template>