<script setup>
import LaptopIcon from '@/Components/Icon/LaptopIcon.vue';
import PrinterIcon from '@/Components/Icon/PrinterIcon.vue';
import CameraIcon from '@/Components/Icon/CameraIcon.vue';
import RouterIcon from '@/Components/Icon/RouterIcon.vue';
</script>

<template>
    <div
        class="flex flex-col p-8 items-start gap-2 overflow-hidden rounded-md bg-white shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700 md:row-span-3 lg:pb-8">
        <div class="px-2">
            <h2 class="text-xl font-semibold text-green-900 mt-4">Layanan Service
            </h2>
            <br>
            <ul class="text-sm/relaxed">
                <li class="flex items-center space-x-2 font-bold">
                    <LaptopIcon /> <span>Service PC/Laptop</span>
                </li>
                <p class="mt-1">Perbaikan dan pemeliharaan untuk semua model dan merek, memastikan
                    operasi yang
                    efisien.</p>
                <br>
                <li class="flex items-center space-x-2 font-bold">
                    <PrinterIcon /> <span>Service Printer</span>
                </li>
                <p class="mt-1">Solusi perbaikan dan pemeliharaan komprehensif untuk menjaga printer
                    Anda dalam
                    kondisi optimal.
                </p>
                <br>
                <li class="flex items-center space-x-2 font-bold animate-pulse">
                    <RouterIcon /> <span>Service Networking</span>
                </li>
                <p class="mt-1 animate-pulse">
                    Layanan perbaikan dan pemeliharaan jaringan yang meliputi instalasi,
                    konfigurasi,
                    dan troubleshooting untuk memastikan jaringan Anda berfungsi dengan lancar dan
                    aman.
                </p>
                <br>
                <li class="flex items-center space-x-2 font-bold animate-pulse">
                    <CameraIcon /> <span>Service CCTV</span>
                </li>
                <p class="mt-1 animate-pulse">
                    Instalasi, perbaikan, dan pemeliharaan sistem CCTV untuk keamanan dan pengawasan
                    optimal. Kami memastikan kamera dan sistem Anda berfungsi dengan baik untuk
                    melindungi properti Anda.
                </p>
            </ul>
        </div>
    </div>
</template>