<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PlatformFooterTable from './PlatformFooterTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  platformFooters: Array,
});

const searchQuery = ref('');

const filteredPlatformFooters = computed(() => {
  if (!searchQuery.value) {
    return props.platformFooters;
  }
  return props.platformFooters.filter(platformFooter =>
    platformFooter.platform.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Platform Footers" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-green-800 leading-tight flex-none px-2 py-4">Platform Footers</h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for the part name" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-md p-4">
            <!-- Your main content here -->
            <PlatformFooterTable :platformFooters="filteredPlatformFooters" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
