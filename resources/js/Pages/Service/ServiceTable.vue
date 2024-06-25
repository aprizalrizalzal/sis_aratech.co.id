<script setup>
import ServiceForm from '@/Pages/Service/ServiceForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    services: Array,
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
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

const closeModal = () => {
    confirmingServiceDeletion.value = false;
    showingModelServiceUpdate.value = false;
};

const start_date = ref('');
const end_date = ref('');

const defaultStartDate = new Date();
defaultStartDate.setDate(defaultStartDate.getDate() - 30);
const defaultEndDate = new Date();

start_date.value = defaultStartDate;
end_date.value = defaultEndDate;

const resetDateFilters = () => {
    start_date.value = defaultStartDate;;
    end_date.value = defaultEndDate;;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const filteredServices = computed(() => {
    let services = props.services;

    if (start_date.value || end_date.value) {
        services = services.filter(service => {
            const dateReceived = new Date(service.date_received);
            const start = start_date.value ? new Date(start_date.value) : null;
            const end = end_date.value ? new Date(end_date.value) : null;

            if (start && end) {
                return dateReceived >= start && dateReceived <= end;
            } else if (start) {
                return dateReceived >= start;
            } else if (end) {
                return dateReceived <= end;
            }

            return true;
        });
    }

    return services;
});

const paginatedServices = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredServices.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredServices.value.length / itemsPerPage);
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

// const handlePrint = () => {

// };
</script>

<template>
    <div class="flex w-full gap-2 justify-between my-4">
        <div class="flex items-center gap-2 bg-white">
            <DateTimePicker id="start_date" label="Start Date" v-model="start_date"
                placeholder="Select Start Date Time" />
            <DateTimePicker id="end_date" label="End Date" v-model="end_date" placeholder="Select End Date Time" />
        </div>
        <div class="my-auto">
            <PrimaryButton @click="resetDateFilters"><span class="py-1 px-3">Reset</span></PrimaryButton>
        </div>
    </div>
    <div class=" overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Customer</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Phone</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Model</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Serial Number</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Date Received</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Items Brought</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Estimated Completion</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(service, index) in paginatedServices" :key="service.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage
                        +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.service_code }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.customer.user.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.customer.phone }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.device.model }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.device.serial_number }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.date_received }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.items_brought }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.estimated_completion }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.status }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalServiceUpdate(service)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <a :href="route('service.print', { service_code: service.service_code })" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Print
                        </a>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmServiceDeletion(service.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-center gap-4 items-center p-6">
            <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
        </div>
    </div>
    <SecondaryButton @click="handlePrint" class="w-full my-4"><span class="py-1 w-full">Print</span>
        <PrinterIcon />
    </SecondaryButton>
    <Modal v-model:show="showingModelServiceUpdate">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <ServiceForm :service="selectedService" :customer="selectedCustomer" :device="selectedDevice" />
        </div>
    </Modal>

    <Modal :show="confirmingServiceDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your Service?
            </h2>

            <p class="mt-1 text-sm text-green-600">
                Once your Service is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteService">
                    Delete Service
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
