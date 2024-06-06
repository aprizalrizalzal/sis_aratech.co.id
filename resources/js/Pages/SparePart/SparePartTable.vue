<script setup>
import SparePartForm from '@/Pages/SparePart/SparePartForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    spareParts: {
        type: Array,
        required: true
    }
});

const showingModelSparePartUpdate = ref(false);
const selectedSparePart = ref(null);

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
                console.error('There was an error!', errors);
            }
        }
    });
};

const closeModal = () => {
    confirmingSparePartDeletion.value = false;
};
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">#</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Price</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(sparePart, index) in spareParts" :key="sparePart.id" class="hover:bg-green-100">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ sparePart.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ sparePart.price }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalSparePartUpdate(sparePart)" class="m-2">Update
                        </SecondaryButton>
                        <DangerButton @click="confirmSparePartDeletion(sparePart.id)" class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
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
                    Once your Service Detai is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteSparePart">
                        Delete Spare Part
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
