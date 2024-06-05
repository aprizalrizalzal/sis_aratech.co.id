<script setup>
import ServiceDetailForm from '@/Pages/ServiceDetail/ServiceDetailForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import ModalForm from '@/Components/ModalForm.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    serviceDetails: {
        type: Array,
        required: true
    }
});

const showingModelServiceDetailUpdate = ref(false);
const selectedServiceDetail = ref(null);
const selectedUser = ref(null);
const selectedService = ref(null);

const showModalServiceDetailUpdate = (serviceDetail) => {
    selectedServiceDetail.value = serviceDetail;
    selectedUser.value = serviceDetail.user;
    selectedService.value = serviceDetail.service;
    showingModelServiceDetailUpdate.value = true;
};

const confirmingServiceDetailDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmServiceDetailDeletion = (serviceDetailId) => {
    confirmingServiceDetailDeletion.value = true;
    form.id = serviceDetailId;
};

const deleteServiceDetail = () => {
    form.delete(route('destroy.service.detail'), {
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
    confirmingServiceDetailDeletion.value = false;
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
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Service Detail Code</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Technician</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Service</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Problem Description</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Repair Description</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Cost</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(serviceDetail, index) in serviceDetails" :key="serviceDetail.id" class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ serviceDetail.service_detail_code }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ serviceDetail.user.name }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ serviceDetail.service.status }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ serviceDetail.problem_description }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ serviceDetail.repair_description }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ serviceDetail.cost }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">
                        <SecondaryButton @click="showModalServiceDetailUpdate(serviceDetail)" class="m-2">Update
                        </SecondaryButton>
                        <DangerButton @click="confirmServiceDetailDeletion(serviceDetail.id)" class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <ModalForm v-model:show="showingModelServiceDetailUpdate">
            <div class="m-6">
                <div class="flex justify-end">
                    <DangerButton @click="showingModelServiceDetailUpdate = false">X</DangerButton>
                </div>
                <ServiceDetailForm :serviceDetail="selectedServiceDetail" :user="selectedUser"
                    :service="selectedService" />
            </div>
        </ModalForm>
        <Modal :show="confirmingServiceDetailDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-green-900">
                    Are you sure you want to delete your Service Detail?
                </h2>

                <p class="mt-1 text-sm text-green-600">
                    Once your Service Detai is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteServiceDetail">
                        Delete Service Detail
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
