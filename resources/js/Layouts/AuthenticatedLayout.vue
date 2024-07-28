<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import NavLink from '@/Components/NavLink.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Footer from '@/Pages/Setting/Footer/Footer.vue';
import SettingIcon from '@/Components/Icon/SettingIcon.vue';
import SidebarLink from '@/Components/SidebarLink.vue';
import DashboardIcon from '@/Components/Icon/DashboardIcon.vue';
import UserIcon from '@/Components/Icon/UserIcon.vue';
import DisplayIcon from '@/Components/Icon/DisplayIcon.vue';
import SparePartIcon from '@/Components/Icon/SparePartIcon.vue';
import CustomerIcon from '@/Components/Icon/CustomerIcon.vue';
import LaptopIcon from '@/Components/Icon/LaptopIcon.vue';
import ServiceDetailIcon from '@/Components/Icon/ServiceDetailIcon.vue';
import PartUsageIcon from '@/Components/Icon/PartUsageIcon.vue';
import ServiceIcon from '@/Components/Icon/ServiceIcon.vue';
import ToolsIcon from '@/Components/Icon/ToolsIcon.vue';

const showingNavigationDropdown = ref(false);
const showingSidebar = ref(false);

const toggleSidebar = () => {
    showingSidebar.value = !showingSidebar.value;
};

const { auth } = usePage().props;
const roles = ref(auth.roles);
const hasRole = (role) => roles.value.includes(role);

const isSuperAdmin = computed(() => hasRole('super-admin'));
const isAdmin = computed(() => hasRole('admin'));
const isUser = computed(() => hasRole('user'));

</script>

<template>
    <div class="min-h-screen">
        <nav class="bg-white border-b border-green-50 shadow-inner">

            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  ">
                <div class="flex justify-between h-24 ">
                    <div v-if="isSuperAdmin" :class="{ 'ml-64 ': isSuperAdmin && showingSidebar }"
                        class="me-2 flex items-center left-0 fixed bg-green-50 bg-opacity-50 rounded">
                        <button @click="toggleSidebar()"
                            class="inline-flex py-9 items-center justify-center rounded p-2 hover:text-green-500 hover:bg-green-50 hover:bg-opacity-50 focus:outline-none focus:bg-green-50 focus:bg-opacity-50 focus:text-green-500 transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                                <!-- Panah ke kanan -->
                                <path v-if="!showingSidebar" fill-rule="evenodd"
                                    d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671" />
                                <!-- Panah ke kiri -->
                                <path v-if="showingSidebar" fill-rule="evenodd"
                                    d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex">
                        <!-- Logo -->
                        <div v-for="header in $page.props.headers" :key="header.id" class="shrink-0 flex items-center">
                            <Link :href="route('show.welcome')">
                            <ApplicationLogo class="ml-8 lg:ml-0 block h-16 w-16" />
                            </Link>
                            <Link :href="route('show.welcome')"
                                class="p-4 text-xl flex items-center font-bold text-green-600 hover:text-green-800 hover:border-green-800 focus:outline-none focus:text-green-800 focus:border-green-800 transition duration-150 ease-in-out">
                            <h1>{{ header.company }}</h1>
                            </Link>

                        </div>

                        <!-- Navigation Links -->
                        <div v-if="!isSuperAdmin" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
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

                            <NavLink v-if="isUser" :href="route('show.service.details')"
                                :active="route().current('show.service.details')">
                                Service Details
                            </NavLink>

                            <NavLink v-if="isUser" :href="route('show.part.usages')"
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
                                    <span class="inline-flex rounded">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded text-green-600 bg-white hover:text-green-800 focus:outline-none transition ease-in-out duration-150">
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
                                    <DropdownLink class="hover:font-bold" :href="route('profile.edit')"> Profile
                                    </DropdownLink>
                                    <DropdownLink class="hover:font-bold" :href="route('logout')" method="post"
                                        as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded text-green-400 hover:text-green-500 hover:bg-green-50 focus:outline-none focus:bg-green-50 focus:text-green-500 transition duration-150 ease-in-out">
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
                <div v-if="!isSuperAdmin" class="pt-2 pb-3 space-y-1 ">
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

                    <ResponsiveNavLink v-if="isUser" :href="route('show.service.details')"
                        :active="route().current('show.service.details')">
                        Service Details
                    </ResponsiveNavLink>

                    <ResponsiveNavLink v-if="isUser" :href="route('show.part.usages')"
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

            <!-- Sidebar for Super Admins -->
            <div v-if="isSuperAdmin && showingSidebar">
                <div class="w-64 h-full overflow-y-auto bg-white rounded border-green-200 fixed top-0 left-0 z-50">
                    <div class="py-4">
                        <div class="flex items-center gap-4 px-6 pb-4 font-bold">
                            <ApplicationLogo class="block h-16 w-16" /> SIService
                            <h2 class="text-lg font-bold text-green-600 ">
                            </h2>
                        </div>
                        <hr>
                        <SidebarLink class="font-bold" :href="route('show.dashboard')"
                            :active="route().current('show.dashboard')" label="Dashboard">
                            <DashboardIcon />
                        </SidebarLink>

                        <SidebarLink :href="route('show.users')" :active="route().current('show.users')" label="Users">
                            <UserIcon />
                        </SidebarLink>

                        <SidebarLink :href="route('setting.edit')" :active="route().current('setting.edit')"
                            label="Setting">
                            <SettingIcon />
                        </SidebarLink>
                        <hr>
                        <SidebarLink :href="route('show.device.types')" :active="route().current('show.device.types')"
                            label="Device Types">
                            <DisplayIcon />
                        </SidebarLink>

                        <SidebarLink :href="route('show.spare.parts')" :active="route().current('show.spare.parts')"
                            label="Spare Parts">
                            <SparePartIcon />
                        </SidebarLink>
                        <hr>
                        <SidebarLink :href="route('show.customers')" :active="route().current('show.customers')"
                            label="Customers">
                            <CustomerIcon />
                        </SidebarLink>

                        <SidebarLink :href="route('show.devices')" :active="route().current('show.devices')"
                            label="Devices">
                            <LaptopIcon />
                        </SidebarLink>

                        <SidebarLink :href="route('show.services')" :active="route().current('show.services')"
                            label="Service">
                            <ServiceIcon />
                        </SidebarLink>
                        <hr>
                        <SidebarLink :href="route('show.service.details')"
                            :active="route().current('show.service.details')" label="Service Detail">
                            <ServiceDetailIcon />
                        </SidebarLink>

                        <SidebarLink :href="route('show.part.usages')" :active="route().current('show.part.usages')"
                            label="Part Usage">
                            <PartUsageIcon />
                        </SidebarLink>
                        <hr>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow w-full" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-4 lg:px-6">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main :class="{ 'lg:ml-64 md:ml-64': isSuperAdmin && showingSidebar }" class="bg-gray-50">
            <slot />
        </main>
        <footer class="pb-4 text-center text-sm text-green-900 bg-white shadow-inner">
            <Footer />
        </footer>
    </div>
</template>
