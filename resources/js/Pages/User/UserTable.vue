<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import UserForm from '@/Pages/User/UserForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import ButtonImage from '@/Components/ButtonImage.vue';
import BackIcon from '@/Components/Icon/BackIcon.vue';
import NextIcon from '@/Components/Icon/NextIcon.vue';

const props = defineProps({
    users: Array,
});

const showingModalAssignRoles = ref(false);
const selectedUser = ref(null);

const { auth } = usePage().props;
const userId = ref(auth.user.id);

const getUserRoles = (user) => {
    return user.roles.length > 0 ? user.roles : [{ id: 'default', name: 'customer' }];
};

const filteredUserId = computed(() => {
    return props.users.filter(user => user.id !== userId.value);
});

const showModalAssignRoles = (user) => {
    selectedUser.value = user;
    showingModalAssignRoles.value = true;
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

const showingModalAssignSuccessfully = ref(false);

const showModalAssignSuccessfully = () => {
    showingModalAssignRoles.value = false;
    showingModalAssignSuccessfully.value = true;
};

const closeModalAssignSuccessfully = () => {
    showingModalAssignSuccessfully.value = false;
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    showingModalAssignRoles.value = false;
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
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 truncate">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">Email</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300 text-left truncate">Role</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in paginatedUsers" :key="user.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center ">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">{{ user.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">{{ user.email }}</td>
                    <td class="py-2 px-4 border-b border-green-300 truncate max-w-xs">
                        <span v-for="role in getUserRoles(user)" :key="role.id">#{{ role.name }}</span>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center truncate">
                        <SecondaryButton @click="showModalAssignRoles(user)">Assign Roles</SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center ">
                        <DangerButton @click="confirmUserDeletion(user.id)">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <ButtonImage class="py-2 border-none shadow-none" @click="previousPage" :disabled="currentPage === 1"><BackIcon /></ButtonImage>
        <span>{{ currentPage }} / {{ totalPages }}</span>
        <ButtonImage class="py-2 border-none shadow-none" @click="nextPage" :disabled="currentPage === totalPages"><NextIcon /></ButtonImage>
    </div>

    <Modal :show="showingModalAssignRoles">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Assign User Roles</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <UserForm :user="selectedUser" @assignRoles="showModalAssignSuccessfully" />
        </div>
    </Modal>

    <Modal maxWidth="xl" :show="showingModalAssignSuccessfully">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Assign User Roles</span>
                <DangerButton @click="closeModalAssignSuccessfully">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <p class="my-4 text-sm text-green-600">
                Assign User Roles Successful!
            </p>
            <div class="mt-2 flex">
                <PrimaryButton @click="closeModalAssignSuccessfully">Ok</PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="confirmingUserDeletion">
        <div class="p-6">
            <h2 class="text-lg font-medium text-green-900">
                Are you sure you want to delete your User?
            </h2>
            <p class="mt-1 text-sm text-green-600">
                Once your User is deleted, all of its resources and data will be permanently deleted.
            </p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteUser">
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
