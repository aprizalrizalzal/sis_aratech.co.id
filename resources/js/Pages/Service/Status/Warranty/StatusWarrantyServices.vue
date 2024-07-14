<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatusWarrantyServiceTable from './StatusWarrantyServiceTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  statusWarrantyServices: Array,
});

const searchQuery = ref('');

const filteredStatusWarrantyServices = computed(() => {
  if (!searchQuery.value) {
    return props.statusWarrantyServices;
  }
  return props.statusWarrantyServices.filter(statusWarrantyService =>
    statusWarrantyService.status.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Status Warranty Service" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-green-800 leading-tight flex-none px-2 py-4">Status Warranty Service
          </h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for status" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-md p-4">
            <!-- Your main content here -->
            <StatusWarrantyServiceTable :statusWarrantyServices="filteredStatusWarrantyServices" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
