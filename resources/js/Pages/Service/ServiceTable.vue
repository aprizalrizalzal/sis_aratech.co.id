<script setup>
import ServiceForm from '@/Pages/Service/ServiceForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import PrinterIcon from '@/Components/Icon/PrinterIcon.vue';

import jsPDF from 'jspdf';
import 'jspdf-autotable';

const page = usePage();

const props = defineProps({
    services: Array,

    customers: Array,
    devices: Array,

    statusWarrantyServices: Array,
    statusServices: Array,
});

const showingModalServiceUpdate = ref(false);
const selectedService = ref(null);
const selectedCustomer = ref(null);
const selectedDevice = ref(null);

const showModalServiceUpdate = (service) => {
    selectedService.value = service;
    selectedCustomer.value = service.customer;
    selectedDevice.value = service.device;
    showingModalServiceUpdate.value = true;
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

const showingModalUpdateSuccessfully = ref(false);

const showModalUpdateSuccessfully = () => {
    showingModalServiceUpdate.value = false;
    showingModalUpdateSuccessfully.value = true;
};

const closeModalUpdateSuccessfully = () => {
    showingModalUpdateSuccessfully.value = false;
};

const closeModal = () => {
    confirmingServiceDeletion.value = false;
    showingModalServiceUpdate.value = false;
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
    pdf.text('Services Report', 42, 38);
    pdf.setFontSize(12);
    pdf.text(`${formatDate(start_date.value)} - ${formatDate(end_date.value)}`, pdf.internal.pageSize.width - 14, 38, { align: 'right' });

    const rows = [];
    const content = printContentEl.querySelectorAll('tbody tr');
    content.forEach((row) => {
        const cells = row.querySelectorAll('td');
        const rowData = Array.from(cells).map(cell => cell.innerText);
        rows.push(rowData);
    });

    const columnWidths = [10, 20, 50, 30, 25, 40, 25, 25, 75, 25, 43, 25];

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
            7: { cellWidth: columnWidths[7] },
            8: { cellWidth: columnWidths[8] },
            9: { cellWidth: columnWidths[9] },
            10: { cellWidth: columnWidths[10] },
            11: { cellWidth: columnWidths[11] },
        },
        theme: 'grid',
    });

    const totalPages = pdf.internal.getNumberOfPages();
    const timestamp = new Date().getTime();

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

    <!-- Table for User Display -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Phone</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Device Type</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Serial Number</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Warranty Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Date Received</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Problem Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Estimated Completion</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Items Brought</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(service, index) in paginatedServices" :key="service.id" class="hover:bg-green-50">
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ (currentPage - 1) * itemsPerPage +
                            index + 1 }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.service_code }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.customer.user.email }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.customer.phone }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.device.device_type.type_name
                        }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.device.serial_number }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.status_warranty_service.status }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.date_received }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.problem_description }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.estimated_completion }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ service.items_brought }}
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{
                            service.status_service.status }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        <SecondaryButton @click="showModalServiceUpdate(service)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        <a :href="route('service.print', { service_code: service.service_code })" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-sm font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <PrinterIcon />
                        </a>
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        <DangerButton @click="confirmServiceDeletion(service.id)" class="m-2">Delete</DangerButton>
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

    <SecondaryButton @click="handlePrint" class="w-full my-4">
        <PrinterIcon /> <span class="py-1 mx-2 w-full">Print / pdf</span>
    </SecondaryButton>

    <!-- Table for PDF -->
    <div ref="printContent" class="overflow-x-auto" style="display: none;">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Phone</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Device Type</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Serial Number</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Warranty Status</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Date Received</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Problem Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Estimated Completion</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Items Brought</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(service, index) in paginatedServices" :key="service.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.service_code }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.customer.user.email }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.customer.phone }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.device.device_type.type_name
                        }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.device.serial_number }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        service.status_warranty_service.status }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.date_received }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.problem_description }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.estimated_completion }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ service.items_brought }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        service.status_service.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal :show="showingModalServiceUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Service</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <ServiceForm :service="selectedService" :customer="selectedCustomer" :device="selectedDevice"
                :customers="customers" :devices="devices" :statusWarrantyServices="statusWarrantyServices"
                :statusServices="statusServices" @updateService="showModalUpdateSuccessfully" />
        </div>
    </Modal>

    <Modal maxWidth="xl" :show="showingModalUpdateSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Service</span>
                <DangerButton @click="closeModalUpdateSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <p class="my-4 text-sm text-green-600">
                Service Update Successful!
            </p>
            <div class="mt-2 flex">
                <PrimaryButton @click="closeModalUpdateSuccessfully">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingServiceDeletion">
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