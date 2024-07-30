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
import BackIcon from '@/Components/Icon/BackIcon.vue';
import NextIcon from '@/Components/Icon/NextIcon.vue';

const props = defineProps({
    headers: Array,
});

const showingModalHeaderUpdateImage = ref(false);
const showingModalHeaderUpdate = ref(false);
const selectedHeaderId = ref(null);
const selectedHeader = ref(null);

const confirmingHeaderDeletion = ref(false);
const form = useForm({
    id: null,
});

const showModalHeaderUpdateImage = (headerId) => {
    selectedHeaderId.value = headerId;
    showingModalHeaderUpdateImage.value = true;
};

const showModalHeaderUpdate = (header) => {
    selectedHeader.value = header;
    showingModalHeaderUpdate.value = true;
};

const confirmHeaderDeletion = (headerId) => {
    confirmingHeaderDeletion.value = true;
    form.id = headerId;
};

const deleteHeader = () => {
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

const showingModalUpdateImageSuccessfully = ref(false);

const showModalUpdateImageSuccessfully = () => {
    showingModalHeaderUpdateImage.value = false;
    showingModalUpdateImageSuccessfully.value = true;
};

const closeModalUpdateImageSuccessfully = () => {
    showingModalUpdateImageSuccessfully.value = false;
};

const showingModalUpdateSuccessfully = ref(false);

const showModalUpdateSuccessfully = () => {
    showingModalHeaderUpdate.value = false;
    showingModalUpdateSuccessfully.value = true;
};

const closeModalUpdateSuccessfully = () => {
    showingModalUpdateSuccessfully.value = false;
};

const closeModal = () => {
    showingModalHeaderUpdateImage.value = false;
    showingModalHeaderUpdate.value = false;
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 truncate">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 truncate">Image</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">Company</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">URL</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">Description</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(header, index) in paginatedHeaders" :key="header.id" class="hover:bg-green-100">
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        {{ (currentPage - 1) * itemsPerPage +
                            index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate">
                        <div class="flex justify-center items-center m-2">
                            <img :src="`${header.image_path}`" :alt="header.Company"
                                class="h-full object-cover rounded me-2" style="max-width: 64px;" />
                            <ButtonImage @click="showModalHeaderUpdateImage(header.id)">
                                <EditIcon />
                            </ButtonImage>
                        </div>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">
                        {{ header.company }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">
                        {{ header.url }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">
                        {{ header.description }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalHeaderUpdate(header)">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmHeaderDeletion(header.id)">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <ButtonImage class="py-2" @click="previousPage" :disabled="currentPage === 1">
            <BackIcon />
        </ButtonImage>
        <span>{{ currentPage }} / {{ totalPages }}</span>
        <ButtonImage class="py-2" @click="nextPage" :disabled="currentPage === totalPages">
            <NextIcon />
        </ButtonImage>
    </div>

    <Modal :show="showingModalHeaderUpdateImage">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Image Header</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2">
            <HeaderForm :headerId="selectedHeaderId" @updateImageHeader="showModalUpdateImageSuccessfully" />
        </div>
    </Modal>

    <Modal maxWidth="xl" :show="showingModalUpdateImageSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Image Header</span>
                <DangerButton @click="closeModalUpdateImageSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2">
            <p class="my-4 text-sm text-green-700">
                Header Image Update Successful!
            </p>
            <div class="mt-2 flex">
                <PrimaryButton @click="closeModalUpdateImageSuccessfully">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="showingModalHeaderUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Header</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2">
            <HeaderForm :header="selectedHeader" @updateHeader="showModalUpdateSuccessfully" />
        </div>
    </Modal>

    <Modal maxWidth="xl" :show="showingModalUpdateSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Header</span>
                <DangerButton @click="closeModalUpdateSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2">
            <p class="my-4 text-sm text-green-700">
                Header Update Successful!
            </p>
            <div class="mt-2 flex">
                <PrimaryButton @click="closeModalUpdateSuccessfully">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingHeaderDeletion">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete this header?
            </h2>

            <p class="mt-1 text-sm text-green-700">
                Once your header is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteHeader">
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
