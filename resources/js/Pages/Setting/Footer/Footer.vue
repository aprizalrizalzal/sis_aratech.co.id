<script setup>
import EnvelopeIcon from '@/Components/Icon/EnvelopeIcon.vue';
import FacebookIcon from '@/Components/Icon/FacebookIcon.vue';
import GeoIcon from '@/Components/Icon/GeoIcon.vue';
import InstagramIcon from '@/Components/Icon/InstagramIcon.vue';
import WhatsappIcon from '@/Components/Icon/WhatsappIcon.vue';
</script>

<template>
    <div class="flex flex-col items-center ">
        <div class="w-full max-w-2xl px-6 lg:max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 mt-8 pb-8 items-start gap-2">
                <div class="px-2 pb-6 text-start">
                    <h2 class="text-xl  font-semibold text-green-900">Sosial Media</h2>
                    <ul class="mt-2 text-sm/relaxed">
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
                    </ul>
                </div>
                <div class="px-2 pb-6 text-start">
                    <h2 class="text-xl  font-semibold text-green-900">Kontak</h2>
                    <ul class="mt-2 text-sm/relaxed">
                        <li class="flex items-center space-x-2">
                            <WhatsappIcon /> <a href="https://wa.me/6282247912220" target="_blank"
                                rel="noopener noreferrer">0822-4791-2220</a>
                        </li>
                        <li class="flex items-center space-x-2 mt-1">
                            <EnvelopeIcon /> <a href="mailto:amitechpt@gmail.com" target="_blank"
                                rel="noopener noreferrer">amitechpt@gmail.com</a>
                        </li>
                        <li class="flex flex-col items-start space-y-2 mt-1 w-full">
                            <div class="flex items-center space-x-2">
                                <GeoIcon /> <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.1749378082686!2d116.1005921!3d-8.6063228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdbfa5721e0e85%3A0xbf58c33e6d2edc3!2sASLI%20Mandiri%20Computer%20-%20AMITech!5e0!3m2!1sen!2sid!4v1623765863965!5m2!1sen!2sid" target="_blank"
                                rel="noopener noreferrer">Jl. Gajah Mada, Pagesangan, Kec. Mataram, Kota Mataram, Nusa Tenggara
                                Bar.</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="px-2 pb-6 text-start">
                    <h2 class="text-xl  font-semibold text-green-900">Unduh Aplikasi</h2>
                    <p class="mt-2 text-sm/relaxed">
                        Dapatkan pengalaman service yang lebih baik! Unduh aplikasi kami sekarang di Play Store dan App Store.
                    </p>
                    <ul class="mt-2 text-sm/relaxed">
                        <li class="flex items-center space-x-2">
                            
                        </li>
                        <li class="flex items-center space-x-2 mt-1">
                            
                        </li>
                    </ul>
                </div>
            </div>
            <p class="relative">SIService-AMITech &copy;2024</p>
        </div>
    </div>
    </template>