<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    status: '',
    description: '',
});

const props = defineProps({
    statusService: Object,
});

if (props.statusService) {
    form.status = props.statusService.status;
    form.description = props.statusService.description;
}

const submitForm = () => {
    if (!props.statusService) {
        form.post(route('store.status.service'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset(),
                emit('addStatusService');
            },
            onError: (errors) => {
                if (errors.status) {
                    alert('addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const statusServiceId = props.statusService.id;
        form.put(route('update.status.service', { id: statusServiceId }), {
            preserveScroll: true,
            onSuccess: () =>  {
                form.data(),
                emit('updateStatusService');
            },
            onError: (errors) => {
                if (errors.status) {
                    alert('update failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    }
};

const emit = defineEmits(
    [
        'addStatusService', 
        'updateStatusService'
    ]
);
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div>
                    <InputLabel for="status" value="Status" />
                    <TextInput id="status" type="text" class="mt-1 block w-full" v-model="form.status"
                        placeholder="Status" required autofocus />
                    <InputError class="mt-2" :message="form.errors.status" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.statusService ? 'Update' : 'Save' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.statusService ? 'update successfully!' : 'added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>