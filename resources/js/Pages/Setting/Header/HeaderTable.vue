<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import HeaderForm from '@/Pages/Setting/Header/HeaderForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import EditIcon from '@/Components/Icon/EditIcon.vue';

const props = defineProps({
    headers: Array,
});

const showingModelHeaderUpdateImage = ref(false);
const showingModelHeaderUpdate = ref(false);
const selectedHeaderId = ref(null);
const selectedHeader = ref(null);

const confirmingHeaderDeletion = ref(false);
const form = useForm({
    id: null,
});

const showModalHeaderUpdateImage = (headerId) => {
    selectedHeaderId.value = headerId;
    showingModelHeaderUpdateImage.value = true;
};

const showModalHeaderUpdate = (header) => {
    selectedHeader.value = header;
    showingModelHeaderUpdate.value = true;
};

const confirmHeaderDeletion = (headerId) => {
    confirmingHeaderDeletion.value = true;
    form.id = headerId;
};

const deleteheader = () => {
    form.delete(route('destroy.header', { id: form.id }), {
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
    showingModelHeaderUpdateImage.value = false;
    showingModelHeaderUpdate.value = false;
    confirmingHeaderDeletion.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 5;

const paginatedHeaders = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.headers.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.headers.length / itemsPerPage);
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Image</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Company</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(header, index) in paginatedHeaders" :key="header.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300">
                        <div class="flex justify-center items-center m-2">
                            <img :src="`${header.image_path}`" :alt="header.Company"
                                class="h-8 object-cover rounded-md mx-2" />
                            <ButtonImage @click="showModalHeaderUpdateImage(header.id)">
                                <EditIcon />
                            </ButtonImage>
                        </div>
                    </td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ header.company }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ header.description }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalHeaderUpdate(header)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmHeaderDeletion(header.id)" class="m-2">Delete</DangerButton>
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

    <Modal :show="showingModelHeaderUpdateImage" @close="closeModal">
        <div class="m-6">
            <div class="flex justify-between items-center">
                <span class="font-bold text-center w-full">Update Image Header</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <HeaderForm :headerId="selectedHeaderId" />
        </div>
    </Modal>

    <Modal :show="showingModelHeaderUpdate" @close="closeModal">
        <div class="m-6">
            <div class="flex justify-between items-center">
                <span class="font-bold text-center w-full">Update Header</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <HeaderForm :header="selectedHeader" />
        </div>
    </Modal>

    <Modal :show="confirmingHeaderDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete this header?
            </h2>

            <p class="mt-1 text-sm text-green-600">
                Once your header is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteheader">
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
