<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CustomerTable from './CustomerTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  customers: Array,
});
const searchQuery = ref('');

const filteredCustomers = computed(() => {
  if (!searchQuery.value) {
    return props.customers;
  }
  return props.customers.filter(customer =>
    customer.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    customer.user.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    customer.phone.includes(searchQuery.value) ||
    customer.address.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Customers" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-lg text-green-800 leading-tight flex-none px-2 py-4">Customers</h2>
        </div>
        <div class="flex items-center">
          <SearchInput v-model:searchQuery="searchQuery" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-md p-4">
            <!-- Your main content here -->
            <CustomerTable :customers="filteredCustomers" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
