<script setup>
import FooterForm from '@/Pages/Setting/Footer/FooterForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    footers: Array,
});

const showingModelFooterUpdate = ref(false);
const selectedFooter = ref(null);

const confirmingFooterDeletion = ref(false);
const form = useForm({
    id: null,
});

const showModalFooterUpdate = (footer) => {
    selectedFooter.value = footer;
    showingModelFooterUpdate.value = true;
};

const confirmFooterDeletion = (footerId) => {
    confirmingFooterDeletion.value = true;
    form.id = footerId;
};

const deleteFooter = () => {
    form.delete(route('destroy.footer', { id: form.id }), {
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
    confirmingFooterDeletion.value = false;
    showingModelFooterUpdate.value = false;
};
</script>

<template>
    <div class=" overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Type</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Platform</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Image</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">URL</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Username</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Value</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(footer, index) in footers" :key="footer.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <img :src="`${footer.image_path}`" :alt="footer.Company"
                            class="w-24 h-24 object-cover rounded-md mx-auto" />
                    </td>
                    <td class="py-2 px-4 border-b border-green-300">{{ footer.type }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ footer.platform }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ footer.url }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ footer.username }}</td>
                    <td class="py-2 px-4 border-b border-green-300">{{ footer.value }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalFooterUpdate(footer)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmFooterDeletion(footer.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal v-model:show="showingModelFooterUpdate">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelFooterUpdate = false">X</DangerButton>
            </div>
            <footerForm :footer="selectedFooter" />
        </div>
    </Modal>

    <Modal :show="confirmingFooterDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete this footer?
            </h2>

            <p class="mt-1 text-sm text-green-600">
                Once your footer is deleted, all of its resources and data will be permanently deleted.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteFooter">
                    Delete footer
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
