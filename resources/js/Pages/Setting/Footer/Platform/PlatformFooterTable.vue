<script setup>
import PlatformFooterForm from './PlatformFooterForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    platformFooters: Array,
});

const showingModelPlatformFooterUpdate = ref(false);
const selectedPlatformFooter = ref(null);

const showModalPlatformFooterUpdate = (platformFooter) => {
    selectedPlatformFooter.value = platformFooter;
    showingModelPlatformFooterUpdate.value = true;
};

const confirmingPlatformFooterDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmPlatformFooterDeletion = (platformFooterId) => {
    confirmingPlatformFooterDeletion.value = true;
    form.id = platformFooterId;
};

const deletePlatformFooter = () => {
    form.delete(route('destroy.platform.footer'), {
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
    showingModelPlatformFooterUpdate.value = false;
    confirmingPlatformFooterDeletion.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedPlatformFooters = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.platformFooters.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.platformFooters.length / itemsPerPage);
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Platform</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(platformFooter, index) in paginatedPlatformFooters" :key="platformFooter.id"
                    class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">{{ platformFooter.platform }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ platformFooter.description }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalPlatformFooterUpdate(platformFooter)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmPlatformFooterDeletion(platformFooter.id)" class="m-2">Delete
                        </DangerButton>
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

    <Modal :show="showingModelPlatformFooterUpdate" @close="closeModal">
        <div class="m-6">
            <div class="flex justify-between items-center">
                <span class="font-bold text-center w-full">Update Platform Footer</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <PlatformFooterForm :platformFooter="selectedPlatformFooter" />
        </div>
    </Modal>

    <Modal :show="confirmingPlatformFooterDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your Platform Footer?
            </h2>

            <p class="mt-1 text-sm text-green-600">
                Once your Platform Footer is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deletePlatformFooter">
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
    scrollbar-width: thin
}
</style>
