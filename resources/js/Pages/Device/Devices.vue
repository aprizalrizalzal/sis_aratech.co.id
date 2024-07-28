<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeviceTable from './DeviceTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  devices: Array,
  deviceTypes: Array,
});

const searchQuery = ref('');

const filteredDevices = computed(() => {
  if (!searchQuery.value) {
    return props.devices;
  }
  return props.devices.filter(device =>
    device.model.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    device.serial_number.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

</script>

<template>

  <Head title="Devices" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-4 px-2">
        <div class="flex items-center">
          <h2 class="font-bold text-green-500 text-lg leading-4 flex-none px-2 py-4">Devices</h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for device Model or Serial Number" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow sm:rounded p-4 sm:p-8">
            <!-- Your main content here -->
            <DeviceTable :devices="filteredDevices" :deviceTypes="deviceTypes" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
