<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PlatformFooterTable from './PlatformFooterTable.vue';
import Modal from '@/Components/Modal.vue';
import PlatformFooterForm from './PlatformFooterForm.vue';
import SearchInput from '@/Components/SearchInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import BackIcon from '@/Components/Icon/BackIcon.vue';

const showModalAddPlatformFooter = ref(false);

const props = defineProps({
  platformFooters: Array,
});

const previousPage = () => {
  window.history.back();
}

const searchQuery = ref('');

const filteredPlatformFooters = computed(() => {
  if (!searchQuery.value) {
    return props.platformFooters;
  }
  return props.platformFooters.filter(platformFooter =>
    platformFooter.platform.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const showingModalAddSuccessfully = ref(false);

const showModalAddSuccessfully = () => {
  showModalAddPlatformFooter.value = false;
  showingModalAddSuccessfully.value = true;
};

const closeModalAddSuccessfully = () => {
  showingModalAddSuccessfully.value = false;
};

const closeModal = () => {
  showModalAddPlatformFooter.value = false;
};
</script>

<template>

  <Head title="Platform Footers" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-4 px-2">
        <div class="flex items-center">
          <SecondaryButton @click="previousPage" style="padding-inline: 8px; border: none; box-shadow: none;">
            <BackIcon />
          </SecondaryButton>
          <h2 class="font-bold text-green-700 text-lg leading-4 flex-none px-2 py-4">Platform</h2>
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
          <div class="bg-white overflow-hidden shadow sm:rounded p-4 sm:p-8">
            <!-- Your main content here -->
            <PlatformFooterTable :platformFooters="filteredPlatformFooters" />
            <SecondaryButton @click="showModalAddPlatformFooter = true" class="w-full py-3">Add Platform Footer
            </SecondaryButton>
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>

  <Modal :show="showModalAddPlatformFooter">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Platform Footer</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2">
      <PlatformFooterForm @addPlatformFooter="showModalAddSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
        <span class="font-bold text-center w-full">Add Platform Footer</span>
        <DangerButton @click="closeModalAddSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2">
      <p class="my-4 text-sm text-green-700">
        Platform Footer Add Successful!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>
</template>
