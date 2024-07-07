<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const form = useForm({
    email: '',
    role: ''
});

const props = defineProps({
    userId: Number,
    user: Object,
});

const getUserRoles = (user) => {
    return user.roles.length > 0 ? user.roles : [{ id: 'default', name: 'customer' }];
};

const assignRole = (role) => {
    form.role = role;
    form.email = props.user.email;
    form.post(route('assign.role'), {
        onSuccess: () => {
            form.reset('role');
        },
        onError: (errors) => {
            console.error('An error occurred:', errors);
        }
    });
};

const removeRole = (role) => {
    form.role = role;
    form.email = props.user.email;
    form.delete(route('remove.role'), {
        onSuccess: () => {
            form.reset('role');
        },
        onError: (errors) => {
            console.error('An error occurred:', errors);
        }
    });
};
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <p class="flex justify-center gap-2">Silahkan pilih peran yang ingin ditambahkan untuk pengguna ini:</p>
            <div class="flex justify-center gap-2">
                <PrimaryButton class="mt-3 mb-3" @click="assignRole('super-admin')">
                    Add #super-admin
                </PrimaryButton>
                <PrimaryButton class="mt-3 mb-3" @click="assignRole('admin')">
                    Add #admin
                </PrimaryButton>
                <PrimaryButton class="mt-3 mb-3" @click="assignRole('user')">
                    Add #user
                </PrimaryButton>
            </div>

            <p class="flex justify-center gap-2 mt-4">Peran yang dimiliki oleh pengguna ini:</p>
            <div class="flex flex-wrap justify-center gap-2">
                <template v-for="role in getUserRoles(props.user)" :key="role.id">
                    <DangerButton class="mt-3 mb-3" @click="removeRole(role.name)">
                        Hapus {{ role.name }}
                    </DangerButton>
                </template>
            </div>
        </div>
    </div>
</template>
