<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    partUsages: {
        type: Array,
        required: true
    }
});

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
                console.error('There was an error!', errors);
            }
        }
    });
};

const closeModal = () => {
    confirmingPartUsageDeletion.value = false;
};
</script>

<style scoped>
/* Tambahkan beberapa styling dasar untuk tabel */
th,
td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #2C7373;
    color: white;
}

td {
    border-bottom: 1px solid #e2e8f0;
}
</style>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">#</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Service Detail</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Spare Part</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Quantity</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(partUsage, index) in partUsages" :key="partUsage.id" class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ partUsage.service_detail.service_detail_code }}
                    </td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ partUsage.spare_part.name }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ partUsage.quantity }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">
                        <SecondaryButton @click="updatePartUsage(partUsage.id)" class="m-2">Update</SecondaryButton>
                        <DangerButton @click="confirmPartUsageDeletion(partUsage.id)" class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal :show="confirmingPartUsageDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-green-900">
                    Are you sure you want to delete your PartUsage?
                </h2>

                <p class="mt-1 text-sm text-green-600">
                    Once your PartUsage is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deletePartUsage">
                        Delete Part Usage
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
