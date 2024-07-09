<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,

    sparePart: Object,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};
</script>

<template>

    <Head title="Spare Part Detail" />
    <nav class="bg-white border-b border-green-50">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                <!-- Left Section: Logo and Title -->
                <div v-for="header in $page.props.headers" :key="header.id" class="flex items-center">
                    <!-- Logo -->
                    <Link :href="route('show.welcome')">
                    <ApplicationLogo class="block h-16 w-16" />
                    </Link>

                    <Link :href="route('show.welcome')"
                        class="p-4 text-lg flex items-center font-bold text-green-900 hover:text-green-900/70 focus:outline-none focus-visible:ring-green-700">
                    {{ header.company }}
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
                <main class="grid mt-4 mb-8">
                    <div class="flex overflow-x-auto m-auto">
                        <div
                            class="grid sm:grid-cols-2 grid-cols-1 justify-between items-stretch rounded-md overflow-hidden shadow-md bg-white hover:bg-green-50 focus:bg-green-50 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-50 focus:ring-offset-2 hover:ring-green-900/20 ring-1 ring-white/[0.05] transition ease-in-out duration-150 m-2 p-4">
                            <div class="h-full flex items-center justify-center p-2">
                                <img :src="sparePart.image_path" :alt="sparePart.name">
                            </div>
                            <div class="text-start sm:py-2 px-2">
                                <h1 class="text-gray-500 font-bold mb-2">{{ sparePart.name }}</h1>
                                <p class="text-gray-500 text-sm/relaxed">
                                    {{ sparePart.category }}
                                </p>
                                <p class="text-gray-500 text-sm/relaxed">
                                    {{ sparePart.description }}
                                </p>
                                <p class="inline-block rounded-md text-gray-500 mt-2">
                                    {{ formatCurrency(sparePart.price) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>
