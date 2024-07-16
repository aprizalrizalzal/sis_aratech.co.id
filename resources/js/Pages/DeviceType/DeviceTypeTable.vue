<script setup>
import DeviceTypeForm from './DeviceTypeForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    deviceTypes: Array,
});

const showingModelDeviceTypeUpdate = ref(false);
const selectedDeviceType = ref(null);

const showModalDeviceTypeUpdate = (deviceType) => {
    selectedDeviceType.value = deviceType;
    showingModelDeviceTypeUpdate.value = true;
};

const confirmingDeviceTypeDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmDeviceTypeDeletion = (deviceTypeId) => {
    confirmingDeviceTypeDeletion.value = true;
    form.id = deviceTypeId;
};

const deleteDeviceType = () => {
    form.delete(route('destroy.device.type'), {
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

const closeModal = () => {
    showingModelDeviceTypeUpdate.value = false;
    confirmingDeviceTypeDeletion.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedDeviceTypes = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.deviceTypes.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.deviceTypes.length / itemsPerPage);
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Type Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(deviceType, index) in paginatedDeviceTypes" :key="deviceType.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ deviceType.type_name }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ deviceType.description }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalDeviceTypeUpdate(deviceType)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmDeviceTypeDeletion(deviceType.id)" class="m-2">Delete
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

    <Modal v-model:show="showingModelDeviceTypeUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center">
                <span class="font-bold text-center w-full">Update Device Type</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <DeviceTypeForm :deviceType="selectedDeviceType" />
        </div>
    </Modal>
    <Modal :show="confirmingDeviceTypeDeletion">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your DeviceType?
            </h2>

            <p class="mt-1 text-sm text-green-600">
                Once your DeviceType is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteDeviceType">
                    Delete Device Type
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
    scrollbar-width: thin
}
</style>
