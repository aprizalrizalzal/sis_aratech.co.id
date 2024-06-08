<script setup>
import ServiceDetailForm from '@/Pages/ServiceDetail/ServiceDetailForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
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
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

const closeModal = () => {
    confirmingServiceDetailDeletion.value = false;
};
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">#</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Detail Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Technician</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Problem Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Repair Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Cost</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(serviceDetail, index) in serviceDetails" :key="serviceDetail.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service_detail_code }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.user.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.service_code }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.problem_description }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.repair_description }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.cost }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <PrimaryButton @click="showModalServiceDetailUpdate(serviceDetail)" class="m-2">Print
                        </PrimaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">

                        <SecondaryButton @click="showModalServiceDetailUpdate(serviceDetail)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmServiceDetailDeletion(serviceDetail.id)" class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal v-model:show="showingModelServiceDetailUpdate">
            <div class="m-6">
                <div class="flex justify-end">
                    <DangerButton @click="showingModelServiceDetailUpdate = false">X</DangerButton>
                </div>
                <ServiceDetailForm :serviceDetail="selectedServiceDetail" :user="selectedUser"
                    :service="selectedService" />
            </div>
        </Modal>
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
