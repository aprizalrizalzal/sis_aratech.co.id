<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatusWarrantyServiceTable from './StatusWarrantyServiceTable.vue';
import Modal from '@/Components/Modal.vue';
import StatusWarrantyServiceForm from './StatusWarrantyServiceForm.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import BackWindowIcon from '@/Components/Icon/BackWindowIcon.vue';

const showModalAddStatusWarrantyService = ref(false);

const props = defineProps({
  statusWarrantyServices: Array,
});

const previousPage = () => {
  window.history.back();
}

const searchQuery = ref('');

const filteredStatusWarrantyServices = computed(() => {
  if (!searchQuery.value) {
    return props.statusWarrantyServices;
  }
  return props.statusWarrantyServices.filter(statusWarrantyService =>
    statusWarrantyService.status.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const showingModalAddSuccessfully = ref(false);

const showModalAddSuccessfully = () => {
  showModalAddStatusWarrantyService.value = false;
  showingModalAddSuccessfully.value = true;
};

const closeModalAddSuccessfully = () => {
  showingModalAddSuccessfully.value = false;
};

const closeModal = () => {
  showModalAddStatusWarrantyService.value = false;
};
</script>

<template>

  <Head title="Status Warranty Service" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center gap-2 px-2">
        <div class="flex items-center">
          <SecondaryButton @click="previousPage" style="padding-inline: 8px; border: none; box-shadow: none;">
            <BackWindowIcon />
          </SecondaryButton>
          <h2 class="font-bold text-green-600 text-lg leading-4 flex-none px-4 py-4">Status Warranty
          </h2>
        </div>
        <div class="flex w-full items-center">
          <SearchInput v-model:searchQuery="searchQuery" placeholder="Search for status" />
        </div>
      </div>
    </template>
    <div class="flex overflow-x-auto">
      <!-- Main Content -->
      <div class="py-8 flex-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow sm:rounded p-4 sm:p-8">
            <!-- Your main content here -->
            <StatusWarrantyServiceTable :statusWarrantyServices="filteredStatusWarrantyServices" />
            <div class="flex flex-col my-2 items-start">
              <SecondaryButton @click="showModalAddStatusWarrantyService = true" class="w-full py-3">Add Status Warranty
                Service
              </SecondaryButton>
            </div>
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>

  <Modal :show="showModalAddStatusWarrantyService">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-800">
        <span class="font-bold text-center w-full">Add Status Warranty Service</span>
        <DangerButton @click="closeModal">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2">
      <StatusWarrantyServiceForm @addStatusWarrantyService="showModalAddSuccessfully" />
    </div>
  </Modal>

  <Modal maxWidth="xl" :show="showingModalAddSuccessfully">
    <div class="m-6">
      <div class="flex justify-between items-center ps-6 ms-6 text-green-800">
        <span class="font-bold text-center w-full">Add Status Warranty Service</span>
        <DangerButton @click="closeModalAddSuccessfully">X</DangerButton>
      </div>
      <hr class="mt-4 mb-2">
      <p class="my-4 text-sm text-green-600">
        Status Warranty Service Add Successful!
      </p>
      <div class="mt-2 flex">
        <PrimaryButton @click="closeModalAddSuccessfully">Ok</PrimaryButton>
      </div>
    </div>
  </Modal>

</template>
