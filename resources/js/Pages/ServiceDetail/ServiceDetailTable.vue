<script setup>
import { ref, computed, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ServiceDetailForm from './ServiceDetailForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PrinterIcon from '@/Components/Icon/PrinterIcon.vue';
import ServiceDetailsPrint from './ServiceDetailsPrint.vue';

const props = defineProps({
    serviceDetails: Array,
});

onMounted(() => {
    console.log('partUsages', props.partUsages);
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

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
    showingModelServiceDetailUpdate.value = false;
};

const start_date = ref('');
const end_date = ref('');

const defaultStartDate = new Date();
defaultStartDate.setDate(defaultStartDate.getDate() - 30);
const defaultEndDate = new Date();

start_date.value = defaultStartDate;
end_date.value = defaultEndDate;

// Add unique keys for DateTimePickers
const datePickerKeys = ref({
    startDate: 0,
    endDate: 0,
});

const resetDateFilters = () => {
    start_date.value = defaultStartDate;
    end_date.value = defaultEndDate;

    // Update the keys to force re-render
    datePickerKeys.value.startDate += 1;
    datePickerKeys.value.endDate += 1;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const filteredServiceDetails = computed(() => {
    let serviceDetails = props.serviceDetails;

    if (start_date.value || end_date.value) {
        serviceDetails = serviceDetails.filter(serviceDetail => {
            const createdDate = new Date(serviceDetail.created_at);
            const start = start_date.value ? new Date(start_date.value) : null;
            const end = end_date.value ? new Date(end_date.value) : null;

            if (start && end) {
                return createdDate >= start && createdDate <= end;
            } else if (start) {
                return createdDate >= start;
            } else if (end) {
                return createdDate <= end;
            }

            return true;
        });
    }

    return serviceDetails;
});

const totalCost = computed(() => {
    return filteredServiceDetails.value.reduce((total, serviceDetail) => {
        const cost = parseFloat(serviceDetail.cost);
        return total + (isNaN(cost) ? 0 : cost);
    }, 0);
});

const paginatedServiceDetails = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredServiceDetails.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredServiceDetails.value.length / itemsPerPage);
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

const printContent = ref(null);

const handlePrint = () => {
    const printContentEl = printContent.value;
    const printWindow = window.open();
    printWindow.document.write(`
     <html>
            <head>
                <title>Print Service Details</title>
                <style>
                    body {
                        font-family: Arial, sans-serif; 
                    }
                    h1 {
                        text-align: center;
                        font-size: 24px;
                        font-weight: bold;
                    }
                    .date-range {
                        text-align: center;
                        font-size: 12px;
                        margin-bottom: 16px;
                    }
                    table {
                        width: 100%;
                        font-size: 12px;
                        border-collapse: collapse;
                        margin-bottom: 16px;
                    }
                    th, td {
                        border: 1px solid black;
                        padding: 8px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    tfoot td {
                        font-weight: bold;
                        text-align: left;
                    }
                    .header-container {
                        align-items: stretch;
                        font-size: 14px;
                        line-height: 1.5;
                    }
                    .header-company {
                        display: flex;
                        
                    }
                    .header-text {
                        font-weight: bold;
                        font-size: 18px;
                    }
                    .header-date {
                        font-size: 12px;
                        margin-top: auto;
                        margin-bottom: auto;
                        margin-left: auto;
                    }
                </style>
            </head>
            <body>
                ${printContentEl.innerHTML}
            </body>
        </html>
  `);
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
};
</script>

<template>
    <div class="flex w-full gap-2 justify-between my-4">
        <div class="flex items-center gap-2 bg-white">
            <DateTimePicker :key="datePickerKeys.startDate" id="start_date" label="Start Date" v-model="start_date"
                placeholder="Select Start Date Time" />
            <DateTimePicker :key="datePickerKeys.endDate" id="end_date" label="End Date" v-model="end_date"
                placeholder="Select End Date Time" />
        </div>
        <div class="my-auto">
            <PrimaryButton @click="resetDateFilters"><span class="py-1 px-3">Reset</span></PrimaryButton>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Detail Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email Technician</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Phone</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Device Type</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Serial Number</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Repair Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Cost</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Notes</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(serviceDetail, index) in paginatedServiceDetails" :key="serviceDetail.id"
                    class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service_detail_code }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.user.email }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.service_code }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        {{ serviceDetail.service.customer.user.email }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.service.customer.phone
                        }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        serviceDetail.service.device.device_type.type_name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        serviceDetail.service.device.serial_number }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.repair_description }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ formatCurrency(serviceDetail.cost) }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ serviceDetail.notes }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <a :href="route('service.detail.print', { service_detail_code: serviceDetail.service_detail_code })"
                            target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Print
                        </a>
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
                <tr>
                    <td colspan="9" class="py-2 px-4 border-b border-green-300 font-semibold">Total Cost</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center font-semibold">{{
                        formatCurrency(totalCost) }}</td>
                    <td colspan="4" class="py-2 px-4 border-b border-green-300"></td>
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

    <div ref="printContent" style="display: none;">
        <ServiceDetailsPrint :serviceDetails="filteredServiceDetails" :startDate="start_date" :endDate="end_date" />
    </div>

    <Modal v-model:show="showingModelServiceDetailUpdate">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelServiceDetailUpdate = false">X</DangerButton>
            </div>
            <ServiceDetailForm :serviceDetail="selectedServiceDetail" :user="selectedUser" :service="selectedService" />
        </div>
    </Modal>

    <Modal :show="confirmingServiceDetailDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your Service Detail?
            </h2>
            <p class="mt-1 text-sm text-green-600">
                Once your Service Detail is deleted, all of its resources and data will be permanently deleted.
            </p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteServiceDetail">
                    Delete Service Detail
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
