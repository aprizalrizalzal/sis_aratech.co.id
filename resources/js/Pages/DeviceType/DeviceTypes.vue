<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeviceTypeTable from './DeviceTypeTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  deviceTypes: Array,
});

const searchQuery = ref('');

const filteredDeviceTypes = computed(() => {
  if (!searchQuery.value) {
    return props.deviceTypes;
  }
  return props.deviceTypes.filter(deviceType =>
    deviceType.type_name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Device Types" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-lg text-green-800 leading-tight flex-none px-2 py-4">Device Types</h2>
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
            <DeviceTypeTable :deviceTypes="filteredDeviceTypes" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
