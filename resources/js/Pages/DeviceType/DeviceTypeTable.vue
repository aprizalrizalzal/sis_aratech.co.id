<script setup>
import DeviceTypeForm from '@/Pages/DeviceType/DeviceTypeForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import ModalForm from '@/Components/ModalForm.vue';
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
                console.error('There was an error!', errors);
            }
        }
    });
};

const closeModal = () => {
    confirmingDeviceTypeDeletion.value = false;
};
</script>

<style scoped>
/* Tambahkan beberapa styling dasar untuk tabel */
th,
td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #256125;
    color: white;
}

td {
    border-bottom: 1px solid #e2e8f0;
}
</style>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">#</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Type Name</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(deviceType, index) in deviceTypes" :key="deviceType.id" class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ deviceType.type_name }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">
                        <SecondaryButton @click="showModalDeviceTypeUpdate(deviceType)" class="m-2">Update
                        </SecondaryButton>
                        <DangerButton @click="confirmDeviceTypeDeletion(deviceType.id)" class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <ModalForm v-model:show="showingModelDeviceTypeUpdate">
            <div class="m-6">
                <div class="flex justify-end">
                    <DangerButton @click="showingModelDeviceTypeUpdate = false">X</DangerButton>
                </div>
                <DeviceTypeForm :deviceType="selectedDeviceType" />
            </div>
        </ModalForm>
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
