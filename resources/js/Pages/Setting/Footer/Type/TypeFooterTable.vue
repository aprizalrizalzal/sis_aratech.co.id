<script setup>
import TypeFooterForm from './TypeFooterForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    typeFooters: Array,
});

const showingModalTypeFooterUpdate = ref(false);
const selectedTypeFooter = ref(null);

const showModalTypeFooterUpdate = (typeFooter) => {
    selectedTypeFooter.value = typeFooter;
    showingModalTypeFooterUpdate.value = true;
};

const confirmingTypeFooterDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmTypeFooterDeletion = (typeFooterId) => {
    confirmingTypeFooterDeletion.value = true;
    form.id = typeFooterId;
};

const deleteTypeFooter = () => {
    form.delete(route('destroy.type.footer'), {
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
    showingModalTypeFooterUpdate.value = false;
    showingModalUpdateSuccessfully.value = true;
};

const closeModalUpdateSuccessfully = () => {
    showingModalUpdateSuccessfully.value = false;
};

const closeModal = () => {
    showingModalTypeFooterUpdate.value = false;
    confirmingTypeFooterDeletion.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedTypeFooters = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.typeFooters.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.typeFooters.length / itemsPerPage);
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 truncate">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">Type</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(typeFooter, index) in paginatedTypeFooters" :key="typeFooter.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">
                        {{ typeFooter.type }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">
                        {{ typeFooter.description }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalTypeFooterUpdate(typeFooter)">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmTypeFooterDeletion(typeFooter.id)">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>{{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>

    <Modal :show="showingModalTypeFooterUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Type Footer</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <TypeFooterForm :typeFooter="selectedTypeFooter" @updateTypeFooter="showModalUpdateSuccessfully" />
        </div>
    </Modal>

    <Modal maxWidth="xl" :show="showingModalUpdateSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Type Footer</span>
                <DangerButton @click="closeModalUpdateSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <p class="my-4 text-sm text-green-600">
                Type Footer Update Successful!
            </p>
            <div class="mt-2 flex">
                <PrimaryButton @click="closeModalUpdateSuccessfully">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingTypeFooterDeletion">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your Type Footer?
            </h2>

            <p class="mt-1 text-sm text-green-600">
                Once your Type Footer is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteTypeFooter">
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
