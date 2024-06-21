<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import HeaderForm from '@/Pages/Setting/Header/HeaderForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
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
                <tr v-for="(header, index) in headers" :key="header.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300">
                        <div class="flex justify-center items-center m-2">
                            <img :src="`${header.image_path}`" :alt="header.Company"
                                class="w-16 h-16 object-cover rounded-md mx-2" />
                            <PrimaryButton @click="showModalHeaderUpdateImage(header.id)" class="m-2 px-0.5 py-0.5">
                                <EditIcon />
                            </PrimaryButton>
                        </div>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300">{{ header.company }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ header.description }}</td>
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

    <Modal v-model:show="showingModelHeaderUpdateImage">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelHeaderUpdateImage = false">X</DangerButton>
            </div>
            <HeaderForm :headerId="selectedHeaderId" />
        </div>
    </Modal>

    <Modal v-model:show="showingModelHeaderUpdate">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelHeaderUpdate = false">X</DangerButton>
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
                    Delete header
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
