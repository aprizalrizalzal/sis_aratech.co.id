<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import PartUsageForm from '@/Pages/PartUsage/PartUsageForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import jsPDF from 'jspdf';
import 'jspdf-autotable';
import PrinterIcon from '@/Components/Icon/PrinterIcon.vue';

const page = usePage();

const props = defineProps({
    partUsages: Array,
    serviceDetails: Array,
    spareParts: Array,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const showingModelPartUsageUpdate = ref(false);
const selectedPartUsage = ref(null);
const selectedServiceDetail = ref(null);
const selectedSparePart = ref(null);

const showModalPartUsageUpdate = (partUsage) => {
    selectedPartUsage.value = partUsage;
    selectedServiceDetail.value = partUsage.service_detail;
    selectedSparePart.value = partUsage.spare_part;
    showingModelPartUsageUpdate.value = true;
};

const confirmingPartUsageDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmPartUsageDeletion = (partUsageId) => {
    confirmingPartUsageDeletion.value = true;
    form.id = partUsageId;
};

const deletePartUsage = () => {
    form.delete(route('destroy.part.usage'), {
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
    showingModelPartUsageUpdate.value = false;
    confirmingPartUsageDeletion.value = false;
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

const filteredPartUsages = computed(() => {
    let partUsages = props.partUsages;

    if (start_date.value || end_date.value) {
        partUsages = partUsages.filter(serviceDetail => {
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

    return partUsages;
});

const paginatedPartUsages = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredPartUsages.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredPartUsages.value.length / itemsPerPage);
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

const totalPrice = computed(() => {
    return filteredPartUsages.value.reduce((total, partUsage) => {
        const price = parseFloat(partUsage.spare_part.price);
        return total + (isNaN(price) ? 0 : price);
    }, 0);
});

const totalQuantity = computed(() => {
    return filteredPartUsages.value.reduce((total, partUsage) => {
        const quantity = parseFloat(partUsage.quantity);
        return total + (isNaN(quantity) ? 0 : quantity);
    }, 0);
});

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
        orientation: 'portrait',
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
        pdf.text(`SIService - ${header.company}`, pdf.internal.pageSize.width / 7, 22);  // Menambahkan nama perusahaan
        pdf.setFontSize(14);
        pdf.text(`${header.description}`, pdf.internal.pageSize.width / 7, 30);  // Menambahkan nama perusahaan
    });

    pdf.setTextColor(0, 125, 0);
    pdf.setFontSize(12);
    pdf.text('Part Usages Report', 42, 38);
    pdf.setFontSize(12);
    pdf.text(`${formatDate(start_date.value)} - ${formatDate(end_date.value)}`, pdf.internal.pageSize.width - 14, 38, { align: 'right' });

    const rows = [];
    const content = printContentEl.querySelectorAll('tbody tr');
    content.forEach((row) => {
        const cells = row.querySelectorAll('td');
        const rowData = Array.from(cells).map(cell => cell.innerText);
        rows.push(rowData);
    });

    const columnWidths = [10, 50, 140, 50, 20];

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
        },
        theme: 'grid',
    });

    const totalPages = pdf.internal.getNumberOfPages();
    const timestamp = new Date().getTime();

    const columnTotalWidths = [200, 50, 20];
    const startY = pdf.autoTable.previous.finalY;
    pdf.autoTable({
        body: [
            ['Total', formatCurrency(totalPrice.value), totalQuantity.value],
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
    <div class=" overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Detail Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Spare Part</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Price</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Quantity</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(partUsage, index) in paginatedPartUsages" :key="partUsage.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        partUsage.service_detail.service_detail_code }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ partUsage.spare_part.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        formatCurrency(partUsage.spare_part.price) }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ partUsage.quantity }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalPartUsageUpdate(partUsage)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmPartUsageDeletion(partUsage.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex flex-col w-full text-center">
        <div class="flex flex-row w-full">
            <p class="py-2 px-4 border-b border-green-300 font-semibold w-full">Total Price</p>
            <p class="py-2 px-4 border-b border-green-300 font-semibold w-full">{{ formatCurrency(totalPrice)
                }}</p>
        </div>
        <div class="flex flex-row w-full">
            <p class="py-2 px-4 border-b border-green-300 font-semibold w-full">Total Quantity</p>
            <p class="py-2 px-4 border-b border-green-300 font-semibold w-full">{{ totalQuantity }}</p>
        </div>
    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>

    <SecondaryButton @click="handlePrint" class="w-full my-4">
        <PrinterIcon /><span class="py-1 w-full">Print / pdf</span>
    </SecondaryButton>

    <div ref="printContent" class="overflow-x-auto" style="display: none;">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Detail Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Spare Part</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Price</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(partUsage, index) in paginatedPartUsages" :key="partUsage.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        partUsage.service_detail.service_detail_code }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center ">{{ partUsage.spare_part.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{
                        formatCurrency(partUsage.spare_part.price) }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ partUsage.quantity }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal :show="showingModelPartUsageUpdate" @close="closeModal">
        <div class="m-6">
            <div class="flex justify-between items-center">
                <span class="font-bold">Update Part Usage</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <PartUsageForm :partUsage="selectedPartUsage" :serviceDetails="serviceDetails" :spareParts="spareParts"
                :serviceDetail="selectedPartUsage.service_detail" :sparePart="selectedPartUsage.spare_part" />
        </div>
    </Modal>
    <Modal :show="confirmingPartUsageDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your PartUsage?
            </h2>
            <p class="mt-1 text-sm text-green-600">
                Once your PartUsage is deleted, all of its resources and data will be permanently deleted.
            </p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deletePartUsage">
                    Delete Part Usage
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
