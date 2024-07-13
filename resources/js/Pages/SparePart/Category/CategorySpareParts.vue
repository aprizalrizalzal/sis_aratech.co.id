<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CategorySparePartTable from './CategorySparePartTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  categorySpareParts: Array,
});

const searchQuery = ref('');

const filteredCategorySpareParts = computed(() => {
  if (!searchQuery.value) {
    return props.categorySpareParts;
  }
  return props.categorySpareParts.filter(categorySparePart =>
    categorySparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Category Spare Parts" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-lg text-green-800 leading-tight flex-none px-2 py-4">Category Spare Parts</h2>
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
            <CategorySparePartTable :categorySpareParts="filteredCategorySpareParts" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
