<script setup>
import StatusWarrantyServiceForm from './StatusWarrantyServiceForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    statusWarrantyServices: Array,
});

const showingModalStatusWarrantyServiceUpdate = ref(false);
const selectedStatusWarrantyService = ref(null);

const showModalStatusWarrantyServiceUpdate = (statusWarrantyService) => {
    selectedStatusWarrantyService.value = statusWarrantyService;
    showingModalStatusWarrantyServiceUpdate.value = true;
};

const confirmingStatusWarrantyServiceDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmStatusWarrantyServiceDeletion = (statusWarrantyServiceId) => {
    confirmingStatusWarrantyServiceDeletion.value = true;
    form.id = statusWarrantyServiceId;
};

const deleteStatusWarrantyService = () => {
    form.delete(route('destroy.status.warranty.service'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: (errors) => {
            if (errors) {
                closeModal();
            } else {
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

const showingModalUpdateSuccessfully = ref(false);

const showModalUpdateSuccessfully = () => {
    showingModalStatusWarrantyServiceUpdate.value = false;
    showingModalUpdateSuccessfully.value = true;
};

const closeModalUpdateSuccessfully = () => {
    showingModalUpdateSuccessfully.value = false;
};

const closeModal = () => {
    showingModalStatusWarrantyServiceUpdate.value = false;
    confirmingStatusWarrantyServiceDeletion.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedStatusWarrantyServices = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.statusWarrantyServices.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.statusWarrantyServices.length / itemsPerPage);
});

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};
</script>

<template>
    <div class=" overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(statusWarrantyService, index) in paginatedStatusWarrantyServices"
                    :key="statusWarrantyService.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ statusWarrantyService.status }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ statusWarrantyService.description }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalStatusWarrantyServiceUpdate(statusWarrantyService)"
                            class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmStatusWarrantyServiceDeletion(statusWarrantyService.id)"
                            class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>

    <Modal :show="showingModalStatusWarrantyServiceUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Status Warranty Service</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <StatusWarrantyServiceForm :statusWarrantyService="selectedStatusWarrantyService" @updateStatusWarrantyService="showModalUpdateSuccessfully"/>
        </div>
    </Modal>

    <Modal :show="showingModalUpdateSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Status Warranty Service</span>
                <DangerButton @click="closeModalUpdateSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <p class="my-4 text-sm text-green-600">
                Status Warranty Service Update Successful!
            </p>
            <div class="mt-2 flex">
                <PrimaryButton @click="closeModalUpdateSuccessfully">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingStatusWarrantyServiceDeletion">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your Status Warranty Service?
            </h2>

            <p class="mt-1 text-sm text-green-600">
                Once your Status Warranty Service is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteStatusWarrantyService">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>

<style scoped>
/* Custom scrollbar style for overflow-x-auto */
.overflow-x-auto::-webkit-scrollbar {
    display: none;
}

.overflow-x-auto {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
