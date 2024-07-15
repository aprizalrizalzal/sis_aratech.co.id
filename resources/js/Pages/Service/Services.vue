<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ServiceTable from './ServiceTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const props = defineProps({
  services: Array,

  customers: Array,
  devices: Array,

  statusWarrantyServices: Array,
  statusServices: Array,
});

const searchQuery = ref('');

const filteredServices = computed(() => {
  if (!searchQuery.value) {
    return props.services;
  }
  return props.services.filter(service =>
    service.service_code.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    service.device.device_type.type_name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Service" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-4">
        <div class="flex items-center">
          <div class="relative">
            <Dropdown align="left" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button type="button"
                            class="inline-flex items-center py-4 border border-transparent text-md leading-4 font-bold rounded-md text-green-800 bg-white hover:text-green-800 focus:outline-none transition ease-in-out duration-150">
                            Services&nbsp;
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <DropdownLink :href="route('show.status.warranty.services')">Status Warranty</DropdownLink>
                    <DropdownLink :href="route('show.status.services')">Status</DropdownLink>
                </template>
            </Dropdown>
          </div>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for Service Code or Device Type" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-md p-4">
            <!-- Your main content here -->
            <ServiceTable :services="filteredServices" :customers="customers" :devices="devices"
              :statusWarrantyServices="statusWarrantyServices" :statusServices="statusServices" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
