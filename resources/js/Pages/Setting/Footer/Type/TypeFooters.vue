<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TypeFooterTable from './TypeFooterTable.vue';
import Modal from '@/Components/Modal.vue';
import TypeFooterForm from './TypeFooterForm.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import BackWindowIcon from '@/Components/Icon/BackWindowIcon.vue';

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

const showingModalAddSuccessfully = ref(false);

const showModalAddSuccessfully = () => {
  showModalAddTypeFooter.value = false;
  showingModalAddSuccessfully.value = true;
};

const closeModalAddSuccessfully = () => {
  showingModalAddSuccessfully.value = false;
};

const closeModal = () => {
  showModalAddTypeFooter.value = false;
};
</script>

<template>

  <Head title="Type Footers" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-2 px-2">
        <div class="flex items-center">
          <SecondaryButton @click="previousPage" style="padding-inline: 8px; border: none; box-shadow: none;">
            <BackWindowIcon />
          </SecondaryButton>
          <h2 class="font-bold text-green-600 text-lg leading-4 flex-none px-4 py-4">Type</h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for type" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-8 flex-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow sm:rounded p-4 sm:p-8">
            <!-- Your main content here -->
            <TypeFooterTable :typeFooters="filteredTypeFooters" />
            <SecondaryButton @click="showModalAddTypeFooter = true" class="w-full py-3">Add Type Footer
            </SecondaryButton>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <Modal :show="showModalAddTypeFooter">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-800">
        <span class="font-bold text-center w-full">Add Type Footer</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2">
      <TypeFooterForm @addTypeFooter="showModalAddSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-800">
        <span class="font-bold text-center w-full">Add Type Footer</span>
        <DangerButton @click="closeModalAddSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2">
      <p class="my-4 text-sm text-green-600">
        Type Footer Add Successful!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>
</template>
