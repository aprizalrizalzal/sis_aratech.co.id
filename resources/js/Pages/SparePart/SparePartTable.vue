<script setup>
import SparePartForm from '@/Pages/SparePart/SparePartForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditIcon from '@/Components/Icon/EditIcon.vue';

const props = defineProps({
    spareParts: Array,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const showingModelSparePartUpdateImage = ref(false);
const showingModelSparePartUpdate = ref(false);
const selectedSparePartId = ref(null);
const selectedSparePart = ref(null);

const showModalSparePartUpdateImage = (sparePartId) => {
    selectedSparePartId.value = sparePartId;
    showingModelSparePartUpdateImage.value = true;
};

const showModalSparePartUpdate = (sparePart) => {
    selectedSparePart.value = sparePart;
    showingModelSparePartUpdate.value = true;
};

const confirmingSparePartDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmSparePartDeletion = (sparePartId) => {
    confirmingSparePartDeletion.value = true;
    form.id = sparePartId;
};

const deleteSparePart = () => {
    form.delete(route('destroy.spare.part'), {
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
    confirmingSparePartDeletion.value = false;
    showingModelSparePartUpdate.value = false;
    showingModelSparePartUpdateImage.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedSpareParts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.spareParts.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.spareParts.length / itemsPerPage);
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Image</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Price</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(sparePart, index) in paginatedSpareParts" :key="sparePart.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ sparePart.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300">
                        <div class="flex justify-center items-center m-2">
                            <img :src="`${sparePart.image_path}`" :alt="sparePart.name"
                                class="w-16 h-16 object-cover rounded-md mx-2" />
                            <PrimaryButton @click="showModalSparePartUpdateImage(sparePart.id)">
                                <EditIcon />
                            </PrimaryButton>
                        </div>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ sparePart.description.replace(/\\n/g, '\n') }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ formatCurrency(sparePart.price) }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalSparePartUpdate(sparePart)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmSparePartDeletion(sparePart.id)" class="m-2">Delete</DangerButton>
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

    <Modal v-model:show="showingModelSparePartUpdateImage">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelSparePartUpdateImage = false">X</DangerButton>
            </div>
            <SparePartForm :sparePartId="selectedSparePartId" />
        </div>
    </Modal>

    <Modal v-model:show="showingModelSparePartUpdate">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelSparePartUpdate = false">X</DangerButton>
            </div>
            <SparePartForm :sparePart="selectedSparePart" />
        </div>
    </Modal>

    <Modal :show="confirmingSparePartDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your Spare Part?
            </h2>
            <p class="mt-1 text-sm text-green-600">
                Once your Service Detail is deleted, all of its resources and data will be permanently deleted.
            </p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteSparePart">
                    Delete Spare Part
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
