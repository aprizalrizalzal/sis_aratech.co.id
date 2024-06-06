<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeviceTable from '@/Pages/Device/DeviceTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  devices: Array,
});

const searchQuery = ref('');

const filteredDevices = computed(() => {
  if (!searchQuery.value) {
    return props.devices;
  }
  return props.devices.filter(device =>
    device.device_type.type_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    device.model.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    device.serial_number.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

</script>

<template>

  <Head title="Devices" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-green-800 leading-tight flex-none">Devices</h2>
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
            <DeviceTable :devices="filteredDevices" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
