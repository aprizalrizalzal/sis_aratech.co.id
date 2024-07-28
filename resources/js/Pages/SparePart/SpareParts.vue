<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SparePartTable from './SparePartTable.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const props = defineProps({
  spareParts: Array,
  categorySpareParts: Array,
});

const searchQuery = ref('');

const filteredSpareParts = computed(() => {
  if (!searchQuery.value) {
    return props.spareParts;
  }
  return props.spareParts.filter(sparePart =>
    sparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    sparePart.description.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<template>

  <Head title="Spare Parts" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-4 px-2">
        <div class="flex items-center">
          <Dropdown align="left" width="48">
            <template #trigger>
              <span class="inline-flex rounded">
                <button type="button"
                  class="inline-flex items-center py-4 border border-transparent text-lg leading-4 font-bold rounded text-green-800 bg-white hover:text-green-800 focus:outline-none transition ease-in-out duration-150">
                  Spare&nbsp;Parts&nbsp;
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                      d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                  </svg>
                </button>
              </span>
            </template>

            <template #content>
              <DropdownLink class="hover:font-bold" :href="route('show.category.spare.parts')">Category</DropdownLink>
            </template>
          </Dropdown>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for the part name or description" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow sm:rounded p-4 sm:p-8">
            <!-- Your main content here -->
            <SparePartTable :spareParts="filteredSpareParts" :categorySpareParts="categorySpareParts" />
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
