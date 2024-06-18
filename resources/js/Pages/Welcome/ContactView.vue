<script setup>
import EnvelopeIcon from '@/Components/Icon/EnvelopeIcon.vue';
import FacebookIcon from '@/Components/Icon/FacebookIcon.vue';
import InstagramIcon from '@/Components/Icon/InstagramIcon.vue';
import WhatsappIcon from '@/Components/Icon/WhatsappIcon.vue';
import GeoIcon from '@/Components/Icon/GeoIcon.vue';
</script>

<template>
    <div
        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 mt-4 p-8 items-start gap-2 overflow-hidden rounded-md bg-white shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700 md:row-span-3 lg:pb-8">
        <div class="px-2">
            <h2 class="text-xl font-semibold text-green-900 mt-4">Kontak</h2>
            <p class="mt-4 text-sm/relaxed">
                Anda dapat menghubungi kami melalui:
            </p>
            <ul class="mt-2 text-sm/relaxed">
                <li class="flex items-center space-x-2">
                    <WhatsappIcon /> <a href="https://wa.me/6282247912220" target="_blank"
                        rel="noopener noreferrer">0822-4791-2220</a><span>/</span><a
                        href="https://wa.me/6287765889202" target="_blank"
                        rel="noopener noreferrer">0877-6588-9202</a>
                </li>
                <li class="flex items-center space-x-2 mt-1">
                    <FacebookIcon />
                    <a href="https://www.facebook.com/profile.php?id=100087543156002" target="_blank"
                        rel="noopener noreferrer">Aslı Mandiri </a>
                </li>
                <li class="flex items-center space-x-2 mt-1">
                    <InstagramIcon />
                    <a href="https://www.instagram.com/asli_mandiri_com/" target="_blank"
                        rel="noopener noreferrer">Aslı Mandiri (@asli_mandiri_com)</a>
                </li>
                <li class="flex items-center space-x-2 mt-1">
                    <EnvelopeIcon /> <a href="mailto:amitechpt@gmail.com" target="_blank"
                        rel="noopener noreferrer">amitechpt@gmail.com</a>
                </li>
                <li class="flex flex-col items-start space-y-2 mt-1 w-full">
                    <div class="flex items-center space-x-2">
                        <GeoIcon />
                        <span>Jl. Gajah Mada, Pagesangan, Kec. Mataram, Kota Mataram, Nusa Tenggara
                            Bar.</span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="relative w-full overflow-hidden rounded-md shadow-xl" style="padding-top: 56.25%;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.1749378082686!2d116.1005921!3d-8.6063228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdbfa5721e0e85%3A0xbf58c33e6d2edc3!2sASLI%20Mandiri%20Computer%20-%20AMITech!5e0!3m2!1sen!2sid!4v1623765863965!5m2!1sen!2sid"
                class="absolute top-0 left-0 w-full h-full border-0" allowfullscreen=""
                loading="lazy"></iframe>
        </div>
    </div>
</template>