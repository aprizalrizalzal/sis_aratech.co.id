<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ModalService from '@/Components/ModalService.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    service: Object,
    message: String
});

const showModalService = ref(false);

const form = useForm({
    service_code: '',
});

const submitForm = () => {
    form.post(route('show'), {
        preserveScroll: true,
        onSuccess: () => {
            showModalService.value = true;
            form.reset;
        },
        onError: (errors) => {
            if (errors.id) {
                alert('Service not found');
            } else {
                console.error('An error occurred:', errors);
            }
        }
    });
};

const closeModalService = () => {
    showModalService.value = false;
    form.reset;
};

</script>

<style scoped>
.table-auto {
    width: 100%;
    border-collapse: collapse;
}

.table-auto th,
.table-auto td {
    border: 1px solid #ddd;
    padding: 8px;
}

.table-auto tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table-auto tr:hover {
    background-color: #ddd;
}

.table-auto th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>

<template>

    <Head title="SIService" />
    <div class="bg-green-100 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#2C7373] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="text-lg font-semibold text-black dark:text-white mt-4 bg-white grid grid-cols-1 items-center gap-2 py-4 lg:grid-cols-3 rounded-lg bg-white p-4 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#2C7373] lg:pb-4 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#2C7373]">
                    <h2
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#2C7373] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        SIService-AMITech
                    </h2>
                    <div class="flex lg:justify-center lg:col-start-2"></div>
                    <nav v-if="canLogin" class="flex flex-1 justify-end text-sm">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#2C7373] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#2C7373] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                            </Link>
                            <Link v-if="canRegister" :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#2C7373] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-4">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 mt-4">
                        <div id="docs-card"
                            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#2C7373] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#2C7373]">
                            <img src="https://diskop.ntbprov.go.id/wp-content/uploads/2024/05/8.jpg"
                                alt="Laravel documentation screenshot"
                                class="aspect-video h-full w-full flex-1 rounded-[10px] object-top object-cover drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)] dark:hidden" />
                            <div class="relative flex items-center gap-6 lg:items-end">
                                <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                    <div
                                        class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#2C7373]/10 sm:size-32">
                                        <ApplicationLogo class="block h-16 w-auto fill-current text-green-800" />
                                    </div>
                                    <div class="pt-3 sm:pt-5 lg:pt-0">
                                        <h2 class="text-xl font-semibold text-black dark:text-white">SIService-AMITech
                                        </h2>
                                        <p class="mt-4 text-sm/relaxed">
                                            Sistem Informasi Service kami membantu Anda mengelola dan memantau layanan
                                            service dengan
                                            mudah dan efisien.
                                        </p>
                                        <div class="relative flex w-full flex-1 items-stretch">
                                            <div class="w-full">
                                                <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                                                    <div>
                                                        <InputLabel for="service_code" value="Service Code" />
                                                        <TextInput id="service_code" type="text"
                                                            class="mt-1 block w-full" v-model="form.service_code"
                                                            placeholder="Service Code" required autofocus />
                                                        <InputError class="mt-3" :message="form.errors.service_code" />
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <PrimaryButton class="mt-3">Search</PrimaryButton>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <ModalService v-if="service" :show="showModalService"
                                            @close="closeModalService">
                                            <div class="p-6">
                                                <div class="flex justify-end">
                                                    <DangerButton @click="closeModalService">X</DangerButton>
                                                </div>
                                                <table class="table-auto w-full mt-6">
                                                    <tbody>
                                                        <tr class="font-bold text-green-900">
                                                            <td class="border px-4 py-2">Service Code</td>
                                                            <td class="border px-4 py-2">{{
                                                                service.service_code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border px-4 py-2 text-sm/relaxed">Customers</td>
                                                            <td class="border px-4 py-2 text-sm/relaxed">{{
                                                                service.customer.name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border px-4 py-2 text-sm/relaxed">Phone</td>
                                                            <td class="border px-4 py-2 text-sm/relaxed">{{
                                                                service.customer.phone }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border px-4 py-2 text-sm/relaxed">Model</td>
                                                            <td class="border px-4 py-2 text-sm/relaxed">{{
                                                                service.device.model }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border px-4 py-2 text-sm/relaxed">Serial Number
                                                            </td>
                                                            <td class="border px-4 py-2 text-sm/relaxed">{{
                                                                service.device.serial_number }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border px-4 py-2 text-sm/relaxed">Date Received
                                                            </td>
                                                            <td class="border px-4 py-2 text-sm/relaxed">{{
                                                                service.date_received }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border px-4 py-2 text-sm/relaxed">Items Brought
                                                            </td>
                                                            <td class="border px-4 py-2 text-sm/relaxed">{{
                                                                service.items_brought }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border px-4 py-2 text-sm/relaxed">Estimated
                                                                Completion
                                                            </td>
                                                            <td class="border px-4 py-2 text-sm/relaxed">{{
                                                                service.estimated_completion
                                                                }}
                                                            </td>
                                                        </tr>
                                                        <tr class="font-bold text-green-900">
                                                            <td class="border px-4 py-2">Status</td>
                                                            <td class="border px-4 py-2 italic">{{ service.status }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </ModalService>
                                        <div v-else>
                                            <p class="font-bold text-red-700">{{ message }}</p>
                                        </div>
                                        <p class="mt-4 text-sm/relaxed">Pastikan Service Code yang dimasukkan adalah
                                            dalam huruf kapital
                                            agar sistem dapat menemukan data yang sesuai dengan benar.</p>
                                        <p class="mt-4 text-sm/relaxed">Harap dicatat: Service Code hanya boleh
                                            menggunakan huruf
                                            kapital. Contohnya: <strong>SNDFGYHN</strong>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#2C7373] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#2C7373]">
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#2C7373]/10 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#2C7373"
                                    class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg>
                            </div>

                            <div class="px-2">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Tentang Kami</h2>

                                <p class="mt-4 text-sm/relaxed">
                                    Asli Mandiri Computer - AMITech adalah spesialis dalam layanan perbaikan dan
                                    penjualan PC/Laptop,
                                    printer, peralatan jaringan, serta aksesoris komputer. Kami berkomitmen untuk
                                    menyediakan pelayanan
                                    berkualitas tinggi yang memenuhi kebutuhan teknologi Anda.
                                </p>
                                <p class="mt-4 text-sm/relaxed">Untuk mengeksplorasi berbagai produk kami,
                                    kunjungi situs
                                    web kami di <a target="_blank" rel="noopener noreferrer"
                                        class="text-green-800 font-bold"
                                        href="http://www.aslimandiri.com">www.aslimandiri.com.</a> Bersama kami, temukan
                                    solusi terbaik
                                    untuk segala kebutuhan teknologi Anda, di mana kepuasan Anda adalah prioritas kami.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#2C7373] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#2C7373]">
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#2C7373]/10 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#2C7373"
                                    class="bi bi-gear" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                                    <path
                                        d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                                </svg>
                            </div>

                            <div class="px-2">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Layanan Service</h2>

                                <ul class="mt-4 text-sm/relaxed">
                                    <li class="font-bold">Service PC/Laptop</li>
                                    <p class="mt-1">Perbaikan dan pemeliharaan untuk semua model dan merek, memastikan
                                        operasi yang
                                        efisien.</p>
                                    <li class="mt-2 font-bold">Service Printer</li>
                                    <p class="mt-1">Solusi perbaikan dan pemeliharaan komprehensif untuk menjaga printer
                                        Anda dalam
                                        kondisi optimal.
                                    </p>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#2C7373] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#2C7373]">
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#2C7373]/10 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#2C7373"
                                    class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                </svg>
                            </div>

                            <div class="px-2">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Kontak</h2>

                                <p class="mt-4 text-sm/relaxed">
                                    Anda dapat menghubungi kami melalui:
                                <ul class="mt-1 text-sm/relaxed">
                                    <li><a href="https://wa.me/6287765889202" target="_blank"
                                            rel="noopener noreferrer">0877-6588-9202</a></li>
                                    <li><a href="https://www.google.com/maps/place/ASLI+Mandiri+Computer+-+AMITech/@-8.6063881,116.1005921,21z/data=!4m6!3m5!1s0x2dcdbfa5721e0e85:0xbf58c33e6d2edc3!8m2!3d-8.6063228!4d116.1006155!16s%2Fg%2F11l6lx74pq?entry=ttu"
                                            target="_blank" rel="noopener noreferrer">Jl. Gajah Mada, Pagesangan, Kec.
                                            Mataram, Kota
                                            Mataram, NTB.</a></li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </main>


                <footer class="py-8 text-center text-sm text-black dark:text-white/70">
                    SIService-AMITech &copy;2024
                </footer>
            </div>
        </div>
    </div>



</template>
