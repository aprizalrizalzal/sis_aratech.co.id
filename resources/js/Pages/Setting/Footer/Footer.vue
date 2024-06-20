<script setup>
import EnvelopeIcon from '@/Components/Icon/EnvelopeIcon.vue';
import FacebookIcon from '@/Components/Icon/FacebookIcon.vue';
import InstagramIcon from '@/Components/Icon/InstagramIcon.vue';
import WhatsappIcon from '@/Components/Icon/WhatsappIcon.vue';
import GeoIcon from '@/Components/Icon/GeoIcon.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="flex flex-col items-center">
        <div v-for="header in $page.props.headers" :key="header.id" class="w-full max-w-2xl px-6 lg:max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 mt-8 pb-8 mx-4 items-start gap-2">
                <div class="text-start">
                    <ApplicationLogo class="block h-16 w-16" />
                    <h2 class="text-xl font-semibold text-green-900">{{ header.company }}</h2>
                    <p class=" mt-4">Jl. Gajah Mada, Pagesangan, Kec. Mataram, Kota Mataram, Nusa Tenggara Bar.</p>
                </div>
                <div class="mt-8 px-2 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">Contact</h2>
                    <ul class="mt-4 text-sm/relaxed">
                        <li class="flex items-center space-x-2 mt-2">
                            <EnvelopeIcon /> <a href="mailto:amitechpt@gmail.com" target="_blank"
                                rel="noopener noreferrer">amitechpt@gmail.com</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <WhatsappIcon /> <a href="https://wa.me/6282247912220" target="_blank"
                                rel="noopener noreferrer">0822-4791-2220</a>
                        </li>
                    </ul>
                </div>
                <div class="mt-8 px-2 pb-6 text-start">
                    <h2 class="text-xl font-semibold text-green-900 mt-8">Social Media</h2>
                    <ul class="mt-4 text-sm/relaxed">
                        <li class="flex items-center space-x-2 mt-1">
                            <EnvelopeIcon /> <a href="mailto:amitechpt@gmail.com" target="_blank"
                                rel="noopener noreferrer">amitechpt@gmail.com</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <WhatsappIcon /> <a href="https://wa.me/6282247912220" target="_blank"
                                rel="noopener noreferrer">0822-4791-2220</a>
                        </li>
                        <li class="flex items-center space-x-2 mt-1">
                            <EnvelopeIcon /> <a href="mailto:amitechpt@gmail.com" target="_blank"
                                rel="noopener noreferrer">amitechpt@gmail.com</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <WhatsappIcon /> <a href="https://wa.me/6282247912220" target="_blank"
                                rel="noopener noreferrer">0822-4791-2220</a>
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
                </div>
            </div>
            <p class="relative">{{ header.company }} &copy;2024</p>
        </div>
    </div>
</template>