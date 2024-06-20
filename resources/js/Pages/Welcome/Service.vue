<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import LaptopIcon from '@/Components/Icon/LaptopIcon.vue';
import PrinterIcon from '@/Components/Icon/PrinterIcon.vue';
import CameraIcon from '@/Components/Icon/CameraIcon.vue';
import RouterIcon from '@/Components/Icon/RouterIcon.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    service: Object,
    message: String,
});

const showModal = ref(false);

const form = useForm({
    service_code: '',
});

const submitForm = () => {
    form.post(route('store.welcome'), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = true;
            form.reset;
        },
        onError: (errors) => {
            if (errors.id) {
                alert('Service Code not found');
            } else {
                console.error('An error occurred:', errors);
            }
        }
    });
};

const closeModal = () => {
    showModal.value = false;
    form.reset;
};
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 mt-4 gap-4">
        <div
            class="flex flex-col p-8 items-start gap-2 overflow-hidden rounded-md bg-white shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700 md:row-span-3 lg:pb-8">
            <h2 class="text-xl font-semibold text-green-900 mt-2">
                SIService-AMITech
            </h2>
            <p class="text-sm/relaxed">
                Sistem Informasi Service kami membantu Anda memantau layanan dengan mudah
                dan efisien.
            </p>
            <div class="relative flex w-full flex-1 items-stretch">
                <div class="w-full">
                    <form @submit.prevent="submitForm" class="mt-2 space-y-2">
                        <div>
                            <InputLabel for="service_code" value="Service Code" />
                            <TextInput id="service_code" type="text" class="mt-2 block w-full" v-model="form.service_code"
                                placeholder="Service Code" required autofocus />
                            <InputError class="mt-2" :message="form.errors.service_code" />
                        </div>
                        <div class="flex justify-end">
                            <PrimaryButton class="mt-2 mb-2">Search</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-sm/relaxed">Pastikan Service Code yang dimasukkan adalah
                dalam huruf kapital
                agar sistem dapat menemukan data yang sesuai dengan benar.</p>
            <p class="text-sm/relaxed">Harap dicatat: Service Code hanya boleh
                menggunakan huruf
                kapital. Contohnya: <strong>SNDFGYHN</strong>.</p>
        </div>
    
        <div
            class="flex flex-col p-8 items-start gap-2 overflow-hidden rounded-md bg-white shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700 md:row-span-3 lg:pb-8">
            <div class="px-2">
                <h2 class="text-xl font-semibold text-green-900 mt-4">About Us
                </h2>
                <p class="text-sm/relaxed mt-2">
                    Asli Mandiri Computer - AMITech penjualan dan spesialis dalam perbaikan PC/laptop, servis printer,
                    peralatan jaringan, dan aksesoris komputer.
                </p>
                <p class="text-sm/relaxed mt-2">
                    Jelajahi produk kami di situs web: <a target="_blank" rel="noopener noreferrer"
                        class="text-green-800 font-bold" href="http://www.aslimandiri.com">www.aslimandiri.com</a>.
                    Temukan solusi terbaik untuk semua kebutuhan teknologi Anda bersama kami, di mana
                    kepuasan
                    Anda adalah prioritas kami.
                </p>
                <ul class="text-sm/relaxed">
                    <li class="flex items-center space-x-2 font-bold mt-4">
                        <LaptopIcon /> <span>Service PC/Laptop</span>
                    </li>
                    <p class="mt-1">Perbaikan dan pemeliharaan untuk semua model dan merek, memastikan
                        operasi yang
                        efisien.</p>
                    <li class="flex items-center space-x-2 font-bold mt-2">
                        <PrinterIcon /> <span>Service Printer</span>
                    </li>
                    <p class="mt-1">Solusi perbaikan dan pemeliharaan komprehensif untuk menjaga printer
                        Anda dalam
                        kondisi optimal.
                    </p>
                    <li class="flex text-white items-center space-x-2 font-bold mt-2">
                        <RouterIcon /> <span>Service Networking</span>
                    </li>
                    <p class="mt-1 text-white">
                        Layanan perbaikan dan pemeliharaan jaringan yang meliputi instalasi,
                        konfigurasi,
                        dan troubleshooting untuk memastikan jaringan Anda berfungsi dengan lancar dan
                        aman.
                    </p>
                    <li class="flex text-white items-center space-x-2 font-bold mt-2">
                        <CameraIcon /> <span>Service CCTV</span>
                    </li>
                    <p class="mt-1 text-white">
                        Instalasi, perbaikan, dan pemeliharaan sistem CCTV untuk keamanan dan pengawasan
                        optimal. Kami memastikan kamera dan sistem Anda berfungsi dengan baik untuk
                        melindungi properti Anda.
                    </p>
                </ul>
            </div>
        </div>
    </div>

    <Modal v-if="service" :show="showModal" @close="closeModal">
        <div class="p-6">
            <table class="table-auto w-full">
                <tbody>
                    <tr class="font-bold text-green-900">
                        <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                            Service Code
                        </td>
                        <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                            {{ service.service_code }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Customers
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.customer.user.name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Phone
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.customer.phone }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Model
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.device.model }}
                        </td>
                    </tr>
                    <tr class="font-bold text-green-900">
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Serial Number
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.device.serial_number }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Date Received
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.date_received }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Items Brought
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.items_brought }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Estimated Completion
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.estimated_completion }}
                        </td>
                    </tr>
                    <tr class="font-bold text-green-900">
                        <td class="py-2 px-4 border border-green-50 text-center">
                            Status
                        </td>
                        <td class="py-2 px-4 border border-green-50 text-center">
                            {{ service.status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end mt-6">
                <DangerButton @click="closeModal">Close</DangerButton>
            </div>
        </div>
    </Modal>

    <Modal v-if="message" :show="showModal" @close="closeModal">
        <div class="p-6">
            <P class="font-bold text-red-900">{{ message }}</P>
            <div class="flex justify-end mt-6">
                <DangerButton @click="closeModal">Close</DangerButton>
            </div>
        </div>
    </Modal>
</template>