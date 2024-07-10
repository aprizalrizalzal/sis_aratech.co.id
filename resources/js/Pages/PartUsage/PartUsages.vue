<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PartUsageTable from './PartUsageTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  partUsages: Array,
});

const searchQuery = ref('');

const filteredPartUsages = computed(() => {
  if (!searchQuery.value) {
    return props.partUsages;
  }
  return props.partUsages.filter(partUsage =>
    partUsage.service_detail.service_detail_code.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    partUsage.spare_part.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Part Usages" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-lg text-green-800 leading-tight flex-none px-2 py-4">Part Usages</h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search Service Detail Code or Spare Part" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-md p-4">
            <!-- Your main content here -->
            <PartUsageTable :partUsages="filteredPartUsages" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
