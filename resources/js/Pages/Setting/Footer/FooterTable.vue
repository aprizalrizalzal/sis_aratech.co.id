<script setup>
import FooterForm from '@/Pages/Setting/Footer/FooterForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import EditIcon from '@/Components/Icon/EditIcon.vue';

const props = defineProps({
    footers: Array,

    typeFooters: Array,
    platformFooters: Array,
});

const showingModelFooterUpdateImage = ref(false);
const showingModelFooterUpdate = ref(false);
const selectedFooterId = ref(null);
const selectedFooter = ref(null);

const confirmingFooterDeletion = ref(false);
const form = useForm({
    id: null,
});

const showModalFooterUpdateImage = (footerId) => {
    selectedFooterId.value = footerId;
    showingModelFooterUpdateImage.value = true;
};

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
    showingModelFooterUpdateImage.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 5;

const paginatedFooters = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.footers.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.footers.length / itemsPerPage);
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
        <table class="min-w-full bg-white border-collapse divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Image</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Type</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Platform</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">URL</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Username</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Value</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(footer, index) in paginatedFooters" :key="footer.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300">
                        <div class="flex justify-center items-center m-2">
                            <img :src="`${footer.image_path}`" :alt="footer.type_footer.type"
                                class="h-16 object-cover rounded-md me-2" />
                            <ButtonImage @click="showModalFooterUpdateImage(footer.id)">
                                <EditIcon />
                            </ButtonImage>
                        </div>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">{{ footer.type_footer.type }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">{{ footer.platform_footer.platform }}
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">{{ footer.url }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ footer.username }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ footer.value }}
                    </td>
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

    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>

    <Modal :show="showingModelFooterUpdateImage">
        <div class="m-6">
            <div class="flex justify-between items-center">
                <span class="font-bold text-center w-full">Update Image Footer</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <FooterForm :footerId="selectedFooterId" />
        </div>
    </Modal>

    <Modal :show="showingModelFooterUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center">
                <span class="font-bold text-center w-full">Update Footer</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <FooterForm :footer="selectedFooter" :typeFooters="typeFooters" :platformFooters="platformFooters" />
        </div>
    </Modal>

    <Modal :show="confirmingFooterDeletion">
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