<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import ServiceDetailForm from './ServiceDetailForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PrinterIcon from '@/Components/Icon/PrinterIcon.vue';

import jsPDF from 'jspdf';
import 'jspdf-autotable';

const page = usePage();

const props = defineProps({
    serviceDetails: Array,
    statusServices: Array,
    services: Array,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const showingModalServiceDetailUpdate = ref(false);
const selectedServiceDetail = ref(null);
const selectedUser = ref(null);
const selectedService = ref(null);

const showModalServiceDetailUpdate = (serviceDetail) => {
    selectedServiceDetail.value = serviceDetail;
    selectedUser.value = serviceDetail.user;
    selectedService.value = serviceDetail.service;
    showingModalServiceDetailUpdate.value = true;
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

const showingModalUpdateSuccessfully = ref(false);

const showModalUpdateSuccessfully = () => {
    showingModalServiceDetailUpdate.value = false;
    showingModalUpdateSuccessfully.value = true;
};

const closeModalUpdateSuccessfully = () => {
    showingModalUpdateSuccessfully.value = false;
};

const closeModal = () => {
    confirmingServiceDetailDeletion.value = false;
    showingModalServiceDetailUpdate.value = false;
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

function formatDate(dateString) {
    const date = new Date(dateString);

    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };

    return date.toLocaleDateString('id-ID', options);
}

const printContent = ref(null);

const handlePrint = () => {
    const pdf = new jsPDF({
        format: 'a3',
        orientation: 'landscape',
    });

    const printContentEl = printContent.value;
    const headerCells = printContentEl.querySelectorAll('thead th');
    const columns = Array.from(headerCells).map(th => th.innerText);

    const logoImage = new Image();
    logoImage.src = 'storage/images/header/company_logo.png'; // Ganti dengan path gambar logo Anda
    pdf.addImage(logoImage, 'PNG', 15, 15, 25, 25); // Menambahkan gambar logo dengan posisi dan ukuran

    const headers = page.props.headers;
    headers.forEach(header => {
        pdf.setFontSize(18);
        pdf.text(`SIService - ${header.company}`, pdf.internal.pageSize.width / 10, 22);  // Menambahkan nama perusahaan
        pdf.setFontSize(14);
        pdf.text(`${header.description}`, pdf.internal.pageSize.width / 10, 30);  // Menambahkan nama perusahaan
    });
    pdf.setTextColor(0, 125, 0);
    pdf.setFontSize(12);
    pdf.text('Service Details Report', 42, 38);
    pdf.setFontSize(12);
    pdf.text(`${formatDate(start_date.value)} - ${formatDate(end_date.value)}`, pdf.internal.pageSize.width - 14, 38, { align: 'right' });

    const rows = [];
    const content = printContentEl.querySelectorAll('tbody tr');
    content.forEach((row) => {
        const cells = row.querySelectorAll('td');
        const rowData = Array.from(cells).map(cell => cell.innerText);
        rows.push(rowData);
    });

    const columnWidths = [10, 20, 50, 30, 30, 110, 30];

    pdf.autoTable({
        head: [columns],
        body: rows,
        startY: 42,
        styles: { font: 'helvetica', fontSize: 10 },
        columnStyles: {
            // Specify styles for each column
            0: { cellWidth: columnWidths[0] },
            1: { cellWidth: columnWidths[1] },
            2: { cellWidth: columnWidths[2] },
            3: { cellWidth: columnWidths[3] },
            4: { cellWidth: columnWidths[4] },
            5: { cellWidth: columnWidths[5] },
            6: { cellWidth: columnWidths[6] },
        },
        theme: 'grid',
    });

    const totalPages = pdf.internal.getNumberOfPages();
    const timestamp = new Date().getTime();

    const columnTotalWidths = [250, 30];
    const startY = pdf.autoTable.previous.finalY;
    pdf.autoTable({
        body: [
            ['Total', formatCurrency(totalCost.value), ''],
        ],
        startY: startY,
        styles: { fontSize: 10, fontStyle: 'bold' },
        columnStyles: {
            0: { cellWidth: columnTotalWidths[0] },
            1: { cellWidth: columnTotalWidths[1] },
            2: { cellWidth: columnTotalWidths[2] },
        },
        theme: 'grid',
    });

    pdf.setPage(totalPages);
    pdf.setFontSize(8);
    pdf.text(`Generated on ${new Date().toLocaleString('en-US')} / ${timestamp} by ${page.props.auth.user.name}`, pdf.internal.pageSize.getWidth() - 20, pdf.internal.pageSize.getHeight() - 10, { align: 'right' });

    const blob = pdf.output('blob');
    const pdfURL = URL.createObjectURL(blob);

    const newTabPdf = window.open('', '_blank');
    newTabPdf.location.href = pdfURL;
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Repair Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Cost</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Notes</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(serviceDetail, index) in paginatedServiceDetails" :key="serviceDetail.id"
                    class="hover:bg-green-50">
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center">
                        {{ (currentPage - 1) * itemsPerPage +
                            index + 1 }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300">
                        {{ serviceDetail.service_detail_code }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300">
                        {{ serviceDetail.user.email }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300">
                        {{ serviceDetail.service.service_code }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300">
                        {{
                            serviceDetail.service.status_service.status }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300">
                        {{ serviceDetail.repair_description }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300">
                        {{ formatCurrency(serviceDetail.cost) }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300">
                        {{ serviceDetail.notes }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalServiceDetailUpdate(serviceDetail)">Update
                        </SecondaryButton>
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center">
                        <a :href="route('service.detail.print', { service_detail_code: serviceDetail.service_detail_code })"
                            target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <PrinterIcon />
                        </a>
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmServiceDetailDeletion(serviceDetail.id)">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex flex-row w-full text-center">
        <p class="py-2 px-4 border-b border-green-300 font-semibold w-full">Total Cost</p>
        <p class="py-2 px-4 border-b border-green-300 font-semibold w-full">{{
            formatCurrency(totalCost) }}</p>

    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>

    <SecondaryButton @click="handlePrint" class="w-full my-4">
        <PrinterIcon /> <span class="py-1 mx-2 w-full">Print / pdf</span>
    </SecondaryButton>

    <div ref="printContent" class="overflow-x-auto" style="display: none;">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Detail Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email Technician</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Repair Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Cost</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(serviceDetail, index) in paginatedServiceDetails" :key="serviceDetail.id"
                    class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ serviceDetail.service_detail_code }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300">{{ serviceDetail.user.email }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ serviceDetail.service.service_code }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300">{{
                        serviceDetail.service.status_service.status }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300">{{ serviceDetail.repair_description }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300">{{ formatCurrency(serviceDetail.cost) }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300">{{ serviceDetail.notes }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal :show="showingModalServiceDetailUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Service Detail</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <ServiceDetailForm :serviceDetail="selectedServiceDetail" :statusServices="statusServices"
                :services="services" :user="selectedUser" :service="selectedService"
                @updateServiceDetail="showModalUpdateSuccessfully" />
        </div>
    </Modal>

    <Modal maxWidth="xl" :show="showingModalUpdateSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Service Detail</span>
                <DangerButton @click="closeModalUpdateSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <p class="my-4 text-sm text-green-600">
                Service Detail Update Successful!
            </p>
            <div class="mt-2 flex">
                <PrimaryButton @click="closeModalUpdateSuccessfully">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingServiceDetailDeletion">
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
