<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ServiceDetailTable from './ServiceDetailTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  serviceDetails: Array,
});

const searchQuery = ref('');

const filteredServiceDetails = computed(() => {
  if (!searchQuery.value) {
    return props.serviceDetails;
  }
  return props.serviceDetails.filter(serviceDetail =>
    serviceDetail.service_detail_code.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.user.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.service_code.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Service Details" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-lg text-green-800 leading-tight flex-none px-2 py-4">Service Details</h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search Service Detail Code, Email Technician or Service Code" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-md p-4">
            <!-- Your main content here -->
            <ServiceDetailTable :serviceDetails="filteredServiceDetails" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
