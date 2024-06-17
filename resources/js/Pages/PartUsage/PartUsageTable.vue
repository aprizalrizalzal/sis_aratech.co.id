<script setup>
import PartUsageForm from '@/Pages/PartUsage/PartUsageForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    partUsages: {
        type: Array,
        required: true
    }
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

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedPartUsages = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.partUsages.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.partUsages.length / itemsPerPage);
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
</script>

<template>
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
                    <td class="py-2 px-4 border-b border-green-300">{{
                        partUsage.service_detail.service_detail_code }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ partUsage.spare_part.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ partUsage.quantity }}</td>
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
