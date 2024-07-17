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

const assignRoles = (role) => {
    form.role = role;
    form.email = props.user.email;
    form.post(route('assign.roles'), {
        onSuccess: () => {
            emit('assignRoles');
        },
        onError: (errors) => {
            const errorMessages = Object.values(errors).flat();
            alert(`${errorMessages}`);
        }
    });
};

const removeRole = (role) => {
    form.role = role;
    form.email = props.user.email;
    form.delete(route('remove.roles'), {
        onSuccess: () => {
            emit('assignRoles');
        },
        onError: (errors) => {
            const errorMessages = Object.values(errors).flat();
            alert(`${errorMessages}`);
        }
    });
};

const emit = defineEmits(['assignRoles']);
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="mt-4 w-full">
            <p class="flex gap-2">Silakan pilih peran yang ingin ditambahkan atau dihapus untuk pengguna <span
                    class="font-bold">#{{
                        props.user.name
                    }}</span></p>
            <div class="flex gap-2">
                <PrimaryButton class="mt-3 mb-3" @click="assignRoles('super-admin')">
                    Add #super-admin
                </PrimaryButton>
                <PrimaryButton class="mt-3 mb-3" @click="assignRoles('admin')">
                    Add #admin
                </PrimaryButton>
                <PrimaryButton class="mt-3 mb-3" @click="assignRoles('user')">
                    Add #user
                </PrimaryButton>
            </div>

            <p class="flex gap-2 mt-4">Peran yang dimiliki oleh pengguna</p>
            <div class="flex flex-wrap gap-2">
                <template v-for="role in getUserRoles(props.user)" :key="role.id">
                    <DangerButton class="mt-3 mb-3" @click="removeRole(role.name)">
                        Remove #{{ role.name }}
                    </DangerButton>
                </template>
            </div>
        </div>
    </div>
</template>
