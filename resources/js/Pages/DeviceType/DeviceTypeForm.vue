<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    type_name: '',
});

const submitForm = () => {
    form.post(route('store.device.type'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => {
            if (errors.type_name) {
                alert('Device Type added failed!');
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
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div>
                    <InputLabel for="type_name" value="Type Name" />
                    <TextInput id="type_name" type="text" class="mt-1 block w-full" v-model="form.type_name"
                        placeholder="Type Name" required autofocus />
                    <InputError class="mt-3" :message="form.errors.type_name" />
                </div>
                <div>
                    <PrimaryButton class="mt-3">Add Device Type</PrimaryButton><span v-if="form.recentlySuccessful"
                        class="text-green-500 ml-2">Device Type added
                        successfully!</span>
                </div>
            </form>
        </div>
    </div>
</template>