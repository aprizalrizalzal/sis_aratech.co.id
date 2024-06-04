<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeviceTable from '@/Pages/Device/DeviceTable.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  devices: {
    type: Array,
    required: true
  }
});

</script>

<template>

  <Head title="Devices" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Devices</h2>
    </template>
    <div class="flex">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Your main content here -->
            <DeviceTable :devices="devices" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
