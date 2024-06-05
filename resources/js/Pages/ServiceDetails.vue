<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ServiceDetailTable from '@/Pages/ServiceDetail/ServiceDetailTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  serviceDetails: {
    type: Array,
    required: true
  }
});

const searchQuery = ref('');

const filteredServiceDetails = computed(() => {
  if (!searchQuery.value) {
    return props.serviceDetails;
  }
  return props.serviceDetails.filter(serviceDetail =>
    serviceDetail.service_detail_code.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.service.service_code.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.problem_description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.repair_description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    serviceDetail.cost.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Service Details" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-green-800 leading-tight flex-none">Service Details</h2>
        </div>
        <div class="flex items-center">
          <SearchInput v-model:searchQuery="searchQuery" />
        </div>
      </div>
    </template>
    <div class="flex">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Your main content here -->
            <ServiceDetailTable :serviceDetails="filteredServiceDetails" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
