<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ServiceTable from '@/Pages/Service/ServiceTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  services: {
    type: Array,
    required: true
  }
});

const searchQuery = ref('');

const filteredServices = computed(() => {
  if (!searchQuery.value) {
    return props.services;
  }
  return props.services.filter(service =>
    service.service_code.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    service.customer.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    service.device.model.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    service.date_received.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    service.items_brought.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    service.estimated_completion.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    service.status.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Service" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-green-800 leading-tight flex-none">Services</h2>
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
            <ServiceTable :services="filteredServices" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
