<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const showingSidebarNavigation = ref(false);

const toggleButtonStyle = computed(() => ({
    marginLeft: showingSidebarNavigation.value ? '100px' : '0px',
}));

</script>

<template>
    <div>
        <div class="min-h-screen bg-green-100 ">
            <nav class="bg-white border-b border-green-100 ">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('welcome')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-green-800" />
                                </Link>
                            </div>

                            <div class="p-4 text-sm flex items-center font-bold">
                                <span>AMITech</span>
                            </div>
                            <!-- Toggle Button -->
                            <div class="flex items-center bg-white">
                                <button @click="showingSidebarNavigation = !showingSidebarNavigation"
                                    :style="toggleButtonStyle"
                                    class="inline-flex items-center justify-center p-2 m-2 rounded-md text-green-400 hover:text-green-500 hover:bg-green-100 focus:outline-none focus:text-green-500 transition duration-150 ease-in-out z-50">
                                    <svg class="h-6 w-6" stroke="#2C7373" fill="none" viewBox="0 0 24 24">
                                        <path :class="{
                                            hidden: showingSidebarNavigation,
                                            'inline-flex': !showingSidebarNavigation,
                                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                        <path :class="{
                                            hidden: !showingSidebarNavigation,
                                            'inline-flex': showingSidebarNavigation,
                                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                            </div>
                            <!-- Sidebar -->
                            <Sidebar :isVisible="showingSidebarNavigation" class="transition-all duration-300" />
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-500 bg-white hover:text-green-700 focus:outline-none transition ease-in-out duration-150">
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
                                class="inline-flex items-center justify-center p-2 rounded-md text-green-400 hover:text-green-500 hover:bg-green-100 focus:outline-none focus:bg-green-100 focus:text-green-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="#2C7373" fill="none" viewBox="0 0 24 24">
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
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">

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
            <main :class="{ 'ml-60': showingSidebarNavigation, 'ml-0': !showingSidebarNavigation }">
                <slot />
            </main>
        </div>
    </div>
</template>
