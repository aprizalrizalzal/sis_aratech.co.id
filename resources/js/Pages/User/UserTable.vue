<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
});

const confirmingUserDeletion = ref(false);

const form = useForm({
    id: null,
});

const confirmUserDeletion = (userId) => {
    confirmingUserDeletion.value = true;
    form.id = userId;
};

const deleteUser = () => {
    form.delete(route('destroy.user'), {
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
    confirmingUserDeletion.value = false;
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
    background-color: #256125;
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
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Name</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Email</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Role</th>
                    <th class="py-2 px-4 border-b border-gray-300 bg-gray-100">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="user.id" class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b border-gray-300">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ user.name }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ user.email }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ user.role }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">
                        <SecondaryButton @click="updateService(user.id)" class="m-2">Update</SecondaryButton>
                        <DangerButton @click="confirmUserDeletion(user.id)" class="m-2">Delete
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-green-900">
                    Are you sure you want to delete your User?
                </h2>

                <p class="mt-1 text-sm text-green-600">
                    Once your Service Detai is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteUser">
                        Delete User
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
