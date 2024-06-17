<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CardView from '@/Components/CardView.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import LaptopIcon from '@/Components/Icon/LaptopIcon.vue';
import PrinterIcon from '@/Components/Icon/PrinterIcon.vue';
import EnvelopeIcon from '@/Components/Icon/EnvelopeIcon.vue';
import FacebookIcon from '@/Components/Icon/FacebookIcon.vue';
import InstagramIcon from '@/Components/Icon/InstagramIcon.vue';
import WhatsappIcon from '@/Components/Icon/WhatsappIcon.vue';
import GeoIcon from '@/Components/Icon/GeoIcon.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SparePartIcon from '@/Components/Icon/SparePartIcon.vue';

const showingNavigationDropdown = ref(false);

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,

    carousels: Array,
    spareParts: Array,
    service: Object,

    message: String,
});

const currentIndex = ref(0);
const intervalId = ref(null);

const next = () => {
    currentIndex.value = (currentIndex.value + 1) % props.carousels.length;
    toggleCarouselVisibility();
};

const prev = () => {
    currentIndex.value = (currentIndex.value - 1 + props.carousels.length) % props.carousels.length;
    toggleCarouselVisibility();
};

const toggleCarouselVisibility = () => {
    props.carousels.forEach((carousel, index) => {
        const element = document.getElementById(`carousel-${index}`);
        if (element) {
            if (index === currentIndex.value) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    });
};

const startAutoSlide = () => {
    intervalId.value = setInterval(next, 5000);
};

const stopAutoSlide = () => {
    clearInterval(intervalId.value);
};

onMounted(() => {
    startAutoSlide();
});

onUnmounted(() => {
    stopAutoSlide();
});

const showModal = ref(false);

const form = useForm({
    service_code: '',
});

const searchQuery = ref('');

const filteredSpareParts = computed(() => {
    if (!searchQuery.value) {
        return props.spareParts;
    }
    return props.spareParts.filter(sparePart =>
        sparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        sparePart.price.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

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

    <Head title="SIService" />
    <nav class="bg-white border-b border-green-50">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                <!-- Left Section: Logo and Title -->
                <div class="flex items-center">
                    <!-- Logo -->
                    <Link :href="route('show.welcome')">
                    <ApplicationLogo class="block h-16 w-16" />
                    </Link>

                    <Link :href="route('show.welcome')"
                        class="p-4 text-lg flex items-center font-bold text-green-900 hover:text-green-900/70 focus:outline-none focus-visible:ring-green-700">
                    SIService-AMITech
                    </Link>
                </div>

                <!-- Right Section: Navigation Links -->
                <div class="hidden space-x-8 sm:flex items-center">
                    <div v-if="canLogin" class="flex items-center text-md font-bold">
                        <div v-if="$page.props.auth.user" class="flex items-center gap-2">
                            <Link :href="route('show.dashboard')"
                                class="rounded-md px-3 py-2 text-green-900 ring-1 ring-transparent transition hover:text-green-900/70 focus:outline-none focus-visible:ring-green-700">
                            Dashboard
                            </Link>
                        </div>
                        <template v-else>
                            <div class="flex items-center gap-2">
                                <Link :href="route('login')"
                                    class="rounded-md px-3 py-2 text-green-900 ring-1 ring-transparent transition hover:text-green-900/70 focus:outline-none focus-visible:ring-green-700">
                                Log in
                                </Link>
                                <Link v-if="canRegister" :href="route('register')"
                                    class="rounded-md px-3 py-2 text-green-900 ring-1 ring-transparent transition hover:text-green-900/70 focus:outline-none focus-visible:ring-green-700">
                                Register
                                </Link>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-green-400 hover:text-green-500 hover:bg-green-50 focus:outline-none focus:bg-green-50 focus:text-green-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="#256125" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path
                                :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
            <div v-if="canLogin" class="pt-2 pb-3 space-y-1">
                <div v-if="$page.props.auth.user">
                    <ResponsiveNavLink v-if="$page.props.auth.user" :href="route('show.dashboard')"
                        :active="route().current('show.dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                </div>
                <template v-else>
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('login')">
                            Login
                        </ResponsiveNavLink>

                        <ResponsiveNavLink v-if="canRegister" :href="route('register')">
                            Register
                        </ResponsiveNavLink>
                    </div>
                </template>

            </div>

        </div>
    </nav>


    <div class="bg-gray-50 text-green-900/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-green-700 selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main class="mt-4">
                    <div v-if="carousels.length"
                        class="text-center text-sm font-bold text-green-900 my-4 bg-white items-center gap-2 rounded-md shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700">
                        <div id="default-carousel" class="relative w-full" data-carousel="slide">
                            <div class="relative h-56 overflow-hidden rounded-md md:h-96">
                                <div v-for="(carousel, index) in carousels" :key="carousel.id" :id="'carousel-' + index"
                                    v-show="index === currentIndex" class="duration-700 ease-in-out">
                                    <img :src="carousel.image_path" :alt="carousel.alt"
                                        class="absolute block w-full -translate-x-1/2 -translate-y-1/4 top-1/4 left-1/2">
                                </div>
                            </div>
                            <div
                                class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                                <button v-for="(carousel, index) in carousels" :key="index" type="button"
                                    :aria-label="'Slide ' + (index + 1)" class="w-3 h-3 rounded-full"
                                    :aria-current="(index === currentIndex).toString()" :data-carousel-slide-to="index"
                                    @click="currentIndex = index; toggleCarouselVisibility();"></button>
                            </div>
                            <button type="button"
                                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-prev @click="prev">
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button"
                                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-next @click="next">
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div v-else>
                        <!-- None -->
                    </div>
                    <div class="flex justify-between items-center pt-4 pb-4 ">
                        <div class="flex items-center">
                            <h2 class=" flex font-semibold text-lg text-green-900 leading-tight flex-none px-2 py-4 ">
                                <span class="hidden lg:block">ASLI Mandiri Computer-</span>
                                <span>AMITech</span>
                            </h2>
                        </div>
                        <div class="flex items-center">
                            <SearchInput v-model:searchQuery="searchQuery" />
                        </div>
                    </div>
                    <div v-if="filteredSpareParts.length"
                        class="grid grid-cols-1 gap-4 lg:grid-cols-5 my-4 items-center text-sm font-bold text-green-900">
                        <CardView v-for="sparePart in filteredSpareParts" :key="sparePart" :name="sparePart.name"
                            :price="formatCurrency(sparePart.price)">
                            <template #img>
                                <img :src="sparePart.image_path" :alt="sparePart.name" class="w-full sm:w-64">
                            </template>
                        </CardView>
                    </div>
                    <div v-else>
                        <!-- None -->
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 mt-4 gap-4">
                        <div id="docs-CardButton"
                            class="flex flex-col p-8 items-start gap-2 overflow-hidden rounded-md bg-white shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700 md:row-span-3 lg:pb-8">
                            <h2 class="text-xl font-semibold text-green-900 mt-2">
                                SIService-AMITech
                            </h2>
                            <p class="text-sm/relaxed">
                                Asli Mandiri Computer - AMITech spesialis dalam perbaikan PC/laptop, servis printer,
                                peralatan jaringan, dan aksesoris komputer. Kami berkomitmen menyediakan layanan
                                berkualitas
                                tinggi untuk memenuhi kebutuhan teknologi Anda.
                            </p>
                            <p class="text-sm/relaxed">
                                Jelajahi produk kami di situs web: <a target="_blank" rel="noopener noreferrer"
                                    class="text-green-800 font-bold"
                                    href="http://www.aslimandiri.com">www.aslimandiri.com</a>.
                                Temukan solusi terbaik untuk semua kebutuhan teknologi Anda bersama kami, di mana
                                kepuasan
                                Anda adalah prioritas kami.
                            </p>
                            <p class="text-sm/relaxed">
                                Sistem Informasi Service kami membantu Anda mengelola dan memantau layanan dengan mudah
                                dan
                                efisien.
                            </p>
                            <div class="relative flex w-full flex-1 items-stretch">
                                <div class="w-full">
                                    <form @submit.prevent="submitForm" class="mt-2 space-y-3">
                                        <div>
                                            <InputLabel for="service_code" value="Service Code" />
                                            <TextInput id="service_code" type="text" class="mt-2 block w-full"
                                                v-model="form.service_code" placeholder="Service Code" required
                                                autofocus />
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
                                </ul>
                            </div>
                        </div>

                    </div>
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
                    <Modal v-if="service" :show="showModal" @close="closeModal">
                        <div class="p-6">
                            <table class="table-auto w-full">
                                <tbody>
                                    <tr>
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
                                            {{ service.customer.name }}
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
                                    <tr class="font-bold text-red-900">
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
                                    <tr class="font-bold text-red-900">
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
                    <div v-else>
                        <p class="font-bold text-red-700">{{ message }}</p>
                    </div>
                </main>
                <footer class="py-8 text-center text-sm text-green-900">
                    SIService-AMITech &copy;2024
                </footer>
            </div>
        </div>
    </div>
</template>
