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
    statusWarrantyService: Object,
});

if (props.statusWarrantyService) {
    form.status = props.statusWarrantyService.status;
    form.description = props.statusWarrantyService.description;
}

const submitForm = () => {
    if (!props.statusWarrantyService) {
        form.post(route('store.status.warranty.service'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('status', 'description'),
                    emit('addStatusWarrantyService');
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
        const statusWarrantyServiceId = props.statusWarrantyService.id;
        form.put(route('update.status.warranty.service', { id: statusWarrantyServiceId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data(),
                    emit('updateStatusWarrantyService');
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
        'addStatusWarrantyService',
        'updateStatusWarrantyService'
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
                    <InputLabel for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-700 focus:border-green-700 focus:ring-green-700 rounded shadow"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.statusWarrantyService ? 'Update' : 'Save' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>