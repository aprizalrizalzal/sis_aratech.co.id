<script setup>
import { useForm } from '@inertiajs/vue3';
import DropdownSelect from '@/Components/DropdownSelect.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    },
    services: {
        type: Array,
        required: true
    }
});

const form = useForm({
    user_id: '',
    service_id: '',
    problem_description: '',
    repair_description: '',
    cost: '',
});

const submitForm = () => {
    form.post(route('store.service.detail'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => {
            if (errors.problem_description || errors.repair_description || errors.cost) {
                alert('Service detail added failed!');
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
                    <DropdownSelect id="user_id" label="Technician" optionProperty="email" valueProperty="id"
                        :options="users" v-model="form.user_id" placeholder="Select Email" />
                </div>
                <div>
                    <DropdownSelect id="service_id" label="Service Code" optionProperty="service_code"
                        valueProperty="id" :options="services" v-model="form.service_id"
                        placeholder="Select Service Code" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="problem_description" value="Problem Description" />
                    <TextInput id="problem_description" type="text" class="mt-1 block w-full"
                        v-model="form.problem_description" placeholder="Problem Description" required autofocus />
                    <InputError class="mt-3" :message="form.errors.problem_description" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="repair_description" value="Repair Description" />
                    <TextInput id="repair_description" type="text" class="mt-1 block w-full"
                        v-model="form.repair_description" placeholder="Repair Description" required autofocus />
                    <InputError class="mt-3" :message="form.errors.repair_description" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="cost" value="Cost" />
                    <TextInput id="cost" type="text" class="mt-1 block w-full" v-model="form.cost" placeholder="Cost"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.cost" />
                </div>
                <div>
                    <PrimaryButton class="mt-3">Add Service Detail</PrimaryButton><span v-if="form.recentlySuccessful"
                        class="text-green-500 ml-2">Service Detail added
                        successfully!</span>
                </div>
            </form>
        </div>
    </div>
</template>