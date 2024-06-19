<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import NavLink from '@/Components/NavLink.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import FooterView from '@/Pages/Setting/FooterView.vue';

const showingNavigationDropdown = ref(false);

const { auth } = usePage().props;
const userRole = ref(auth.user.role);

const isSuperAdmin = computed(() => userRole.value === 'super admin');
const isAdmin = computed(() => userRole.value === 'admin');
const isTechnician = computed(() => userRole.value === 'technician');

</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white border-b border-green-50">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
                <div class="flex justify-between h-24">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('show.welcome')">
                            <ApplicationLogo class="block h-16 w-16 fill-current" />
                            </Link>
                            <Link :href="route('show.welcome')"
                                class="p-4 text-lg flex items-center font-bold text-green-600 hover:text-green-800 hover:border-green-800 focus:outline-none focus:text-green-800 focus:border-green-800 transition duration-150 ease-in-out">
                            SIService-AMITech
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                            <NavLink :href="route('show.dashboard')" :active="route().current('show.dashboard')">
                                Dashboard
                            </NavLink>

                            <NavLink v-if="isSuperAdmin" :href="route('show.users')"
                                :active="route().current('show.users')">
                                Users
                            </NavLink>

                            <NavLink v-if="isSuperAdmin" :href="route('show.device.types')"
                                :active="route().current('show.device.types')">
                                Device Types
                            </NavLink>

                            <NavLink v-if="isSuperAdmin" :href="route('show.spare.parts')"
                                :active="route().current('show.spare.parts')">
                                Spare Parts
                            </NavLink>

                            <NavLink v-if="isAdmin" :href="route('show.customers')"
                                :active="route().current('show.customers')">
                                Customers
                            </NavLink>

                            <NavLink v-if="isAdmin" :href="route('show.devices')"
                                :active="route().current('show.devices')">
                                Devices
                            </NavLink>

                            <NavLink v-if="isAdmin" :href="route('show.services')"
                                :active="route().current('show.services')">
                                Services
                            </NavLink>

                            <NavLink v-if="isTechnician" :href="route('show.service.details')"
                                :active="route().current('show.service.details')">
                                Service Details
                            </NavLink>

                            <NavLink v-if="isTechnician" :href="route('show.part.usages')"
                                :active="route().current('show.part.usages')">
                                Part Usages
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-600 bg-white hover:text-green-800 focus:outline-none transition ease-in-out duration-150">
                                            {{ $page.props.auth.user.name }}&nbsp;
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                    <DropdownLink v-if="isSuperAdmin" :href="route('setting.edit')"> Setting </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-green-400 hover:text-green-500 hover:bg-green-50 focus:outline-none focus:bg-green-50 focus:text-green-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="#256125" fill="none" viewBox="0 0 24 24">
                                <path :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">

                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('show.dashboard')" :active="route().current('show.dashboard')">
                        Dashboard
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isSuperAdmin" :href="route('show.users')"
                        :active="route().current('show.users')">
                        Users
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isSuperAdmin" :href="route('show.device.types')"
                        :active="route().current('show.device.types')">
                        Device Types
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isSuperAdmin" :href="route('show.spare.parts')"
                        :active="route().current('show.spare.parts')">
                        Spare Parts
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isAdmin" :href="route('show.customers')"
                        :active="route().current('show.customers')">
                        Customers
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isAdmin" :href="route('show.devices')"
                        :active="route().current('show.devices')">
                        Devices
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isAdmin" :href="route('show.services')"
                        :active="route().current('show.services')">
                        Services
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isTechnician" :href="route('show.service.details')"
                        :active="route().current('show.service.details')">
                        Service Details
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isTechnician" :href="route('show.part.usages')"
                        :active="route().current('show.part.usages')">
                        Part Usages
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-green-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-green-800">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="font-medium text-sm text-green-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-4 lg:px-6">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
        <footer class="mt-8 pb-4 text-center text-sm text-green-900 bg-white">
            <FooterView />
        </footer>
    </div>
</template>
