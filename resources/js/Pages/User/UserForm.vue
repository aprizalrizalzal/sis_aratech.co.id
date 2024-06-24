<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const form = useForm({

});

const props = defineProps({
    userId: Number,
    user: Object,
});

const getUserRoles = (user) => {
    return user.roles.length > 0 ? user.roles : [{ id: 'default', name: 'customer' }];
};

if (props.user) {

}

const submitForm = () => {
    const userId = props.user.id;
    form.put(route('update.user', { id: userId }), {
        preserveScroll: true,
        onSuccess: () => {
            form.data();
        },
        onError: (errors) => {
            if (errors.name || errors.price) {
                alert('User update failed!');
            } else {
                console.error('An error occurred:', errors);
            }
        }
    });
};

</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-2">
                <p class="flex justify-center gap-2" >User <span class="text-green-800">{{props.user.name}}</span> dengan peran <span class="text-green-800" v-for="role in getUserRoles(user)" :key="role.id">{{ role.name }}</span></p>
                <p class="flex justify-center gap-2" >Silakan pilih peran yang ingin ditambahkan untuk pengguna ini:</p>
                
                <div class="flex justify-center gap-2">
                    <PrimaryButton class="mt-3 mb-3" :disabled="form.processing">
                        Add Role Super Admin
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        Role User updated successfully!
                    </span>

                    <PrimaryButton class="mt-3 mb-3" :disabled="form.processing">
                        Add Role Admin
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        Role User updated successfully!
                    </span>

                    <PrimaryButton class="mt-3 mb-3" :disabled="form.processing">
                        Add Role User
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        Role User updated successfully!
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
