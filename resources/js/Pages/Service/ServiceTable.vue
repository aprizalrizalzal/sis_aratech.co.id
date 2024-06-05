<script setup>
import ServiceForm from '@/Pages/Service/ServiceForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import ModalForm from '@/Components/ModalForm.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    services: {
        type: Array,
        required: true
    }
});

const showingModelServiceUpdate = ref(false);
const selectedService = ref(null);
const selectedCustomer = ref(null);
const selectedDevice = ref(null);

const showModalServiceUpdate = (service) => {
    selectedService.value = service;
    selectedCustomer.value = service.customer;
    selectedDevice.value = service.device;
    showingModelServiceUpdate.value = true;
};

const confirmingServiceDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmServiceDeletion = (serviceId) => {
    confirmingServiceDeletion.value = true;
    form.id = serviceId;
};

const deleteService = () => {
    form.delete(route('destroy.service'), {
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
    confirmingServiceDeletion.value = false;
};
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">#</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Customer</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Device</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Date Received</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Items Brought</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Estimated Completion</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(service, index) in services" :key="service.id" class="hover:bg-green-100">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.service_code }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.customer.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.device.model }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.date_received }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.items_brought }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.estimated_completion }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.status }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalServiceUpdate(service)" class="m-2">Update
                        </SecondaryButton>
                        <DangerButton @click="confirmServiceDeletion(service.id)" class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <ModalForm v-model:show="showingModelServiceUpdate">
            <div class="m-6">
                <div class="flex justify-end">
                    <DangerButton @click="showingModelServiceUpdate = false">X</DangerButton>
                </div>
                <ServiceForm :service="selectedService" :customer="selectedCustomer" :device="selectedDevice" />
            </div>
        </ModalForm>
        <Modal :show="confirmingServiceDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-green-900">
                    Are you sure you want to delete your Service?
                </h2>

                <p class="mt-1 text-sm text-green-600">
                    Once your Service is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteService">
                        Delete Service
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
