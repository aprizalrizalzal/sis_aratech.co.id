<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TypeFooterTable from './TypeFooterTable.vue';
import Modal from '@/Components/Modal.vue';
import TypeFooterForm from './TypeFooterForm.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import BackIcon from '@/Components/Icon/BackIcon.vue';

const showModalAddTypeFooter = ref(false);

const props = defineProps({
  typeFooters: Array,
});

const previousPage = () => {
  window.history.back();
}

const searchQuery = ref('');

const filteredTypeFooters = computed(() => {
  if (!searchQuery.value) {
    return props.typeFooters;
  }
  return props.typeFooters.filter(typeFooter =>
    typeFooter.type.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const closeModal = () => {
  showModalAddTypeFooter.value = false;
};
</script>

<template>

  <Head title="Type Footers" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-4 px-2">
        <div class="flex items-center">
          <SecondaryButton @click="previousPage" style="padding-inline: 8px; border: none; box-shadow: none;">
            <BackIcon />
          </SecondaryButton>
          <h2 class="font-semibold text-green-800 leading-tight flex-none px-2 py-4">Type</h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for type" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-6 flex-1 transition-all duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-md p-4">
            <!-- Your main content here -->
            <TypeFooterTable :typeFooters="filteredTypeFooters" />
            <SecondaryButton @click="showModalAddTypeFooter = true" class="w-full">Add Type Footer</SecondaryButton>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <Modal :show="showModalAddTypeFooter">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Type Footer</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <TypeFooterForm />
    </div>
  </Modal>
</template>
