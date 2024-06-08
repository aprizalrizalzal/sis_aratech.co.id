<script setup>
import DeviceTypeForm from '@/Pages/DeviceType/DeviceTypeForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    deviceTypes: {
        type: Array,
        required: true
    }
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
    confirmingDeviceTypeDeletion.value = false;
};
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">#</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Type Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(deviceType, index) in deviceTypes" :key="deviceType.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ deviceType.type_name }}</td>
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
        <Modal v-model:show="showingModelDeviceTypeUpdate">
            <div class="m-6">
                <div class="flex justify-end">
                    <DangerButton @click="showingModelDeviceTypeUpdate = false">X</DangerButton>
                </div>
                <DeviceTypeForm :deviceType="selectedDeviceType" />
            </div>
        </Modal>
        <Modal :show="confirmingDeviceTypeDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-green-900">
                    Are you sure you want to delete your DeviceType?
                </h2>

                <p class="mt-1 text-sm text-green-600">
                    Once your DeviceType is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteDeviceType">
                        Delete Device Type
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
