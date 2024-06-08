<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SparePartTable from '@/Pages/SparePart/SparePartTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  spareParts: Array,
});

const searchQuery = ref('');

const filteredSpareParts = computed(() => {
  if (!searchQuery.value) {
    return props.spareParts;
  }
  return props.spareParts.filter(sparePart =>
    sparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    sparePart.price.toString().toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Spare Parts" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h2 class="font-semibold text-lg text-green-800 leading-tight flex-none">Spare Parts</h2>
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
            <SparePartTable :spareParts="filteredSpareParts" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
