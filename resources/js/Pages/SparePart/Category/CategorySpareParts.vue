<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CategorySparePartTable from './CategorySparePartTable.vue';
import Modal from '@/Components/Modal.vue';
import CategorySparePartForm from './CategorySparePartForm.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import BackIcon from '@/Components/Icon/BackIcon.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const showModalAddCategorySparePart = ref(false);

const props = defineProps({
  categorySpareParts: Array,
});

const previousPage = () => {
  window.history.back();
}

const searchQuery = ref('');

const filteredCategorySpareParts = computed(() => {
  if (!searchQuery.value) {
    return props.categorySpareParts;
  }
  return props.categorySpareParts.filter(categorySparePart =>
    categorySparePart.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const showingModalAddSuccessfully = ref(false);

const showModalAddSuccessfully = () => {
  showModalAddCategorySparePart.value = false;
  showingModalAddSuccessfully.value = true;
};

const closeModalAddSuccessfully = () => {
  showingModalAddSuccessfully.value = false;
};

const closeModal = () => {
  showModalAddCategorySparePart.value = false;
};
</script>

<template>

  <Head title="Category Spare Parts" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-4 px-2">
        <div class="flex items-center">
          <SecondaryButton @click="previousPage" style="padding-inline: 8px; border: none; box-shadow: none;">
            <BackIcon />
          </SecondaryButton>
          <h2 class="font-semibold text-green-800 leading-tight flex-none px-2 py-4">Category</h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for Category" />
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
            <SecondaryButton @click="showModalAddCategorySparePart = true" class="w-full">Add Category Spare Part
            </SecondaryButton>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <Modal :show="showModalAddCategorySparePart">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Category Spare Part</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2 border-green-100">
      <CategorySparePartForm @addCategorySparePart="showModalAddSuccessfully"/>
    </div>
  </Modal>

  <Modal :show="showingModalAddSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Add Category Spare Part</span>
                <DangerButton @click="closeModalAddSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <p class="my-4 text-sm text-green-600">
                Adding  Spare Parts Successfully!
            </p>
            <div class="mt-2 flex">
                <SecondaryButton @click="closeModalAddSuccessfully">Ok</SecondaryButton>
            </div>
        </div>
    </Modal>
</template>
