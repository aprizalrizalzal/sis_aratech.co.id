<script setup>
import UserForm from '@/Pages/User/UserForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    users: Array,
});

const showingModelUserUpdate = ref(false);
const selectedUser = ref(null);

const { auth } = usePage().props;
const userId = ref(auth.user.id);

const getUserRoles = (user) => {
    return user.roles.length > 0 ? user.roles : [{ id: 'default', name: 'customer' }];
};

const filteredUserId = computed(() => {
    return props.users.filter(user => user.id !== userId.value);
});

const showModalUserUpdate = (user) => {
    selectedUser.value = user;
    showingModelUserUpdate.value = true;
};

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
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    showingModelUserUpdate.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredUserId.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredUserId.value.length / itemsPerPage);
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Role</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in paginatedUsers" :key="user.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ user.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ user.email }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <span v-for="role in getUserRoles(user)" :key="role.id">[ {{ role.name }} ]</span>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalUserUpdate(user)" class="m-2">Update
                        </SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmUserDeletion(user.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-center gap-4 items-center p-6">
            <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
        </div>
    </div>

    <Modal v-model:show="showingModelUserUpdate">
        <div class="m-6">
            <div class="flex justify-end">
                <DangerButton @click="showingModelUserUpdate = false">X</DangerButton>
            </div>
            <UserForm :user="selectedUser" />
        </div>
    </Modal>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your User?
            </h2>
            <p class="mt-1 text-sm text-green-600">
                Once your Service Detail is deleted, all of its resources and data will be permanently deleted.
            </p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteUser">
                    Delete User
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
