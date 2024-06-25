<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PartUsageForm from '@/Pages/PartUsage/PartUsageForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    partUsages: Array,
});

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
    confirmingPartUsageDeletion.value = false;
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Service Detail Code</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Spare Part</th>
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
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ partUsage.spare_part.name }}</td>
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

        <div class="flex justify-center gap-4 items-center p-6">
            <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
        </div>
    </div>
    <SecondaryButton @click="handlePrint" class="w-full my-4"><span class="py-1 w-full">Print</span>
        <PrinterIcon />
    </SecondaryButton>

    <Modal v-model:show="showingModelPartUsageUpdate">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelPartUsageUpdate = false">X</DangerButton>
            </div>
            <PartUsageForm :partUsage="selectedPartUsage" :serviceDetail="selectedPartUsage.service_detail"
                :sparePart="selectedPartUsage.spare_part" />
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
