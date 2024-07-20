<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    type_name: '',
    description: '',
});

const props = defineProps({
    deviceType: Object,
});

if (props.deviceType) {
    form.type_name = props.deviceType.type_name;
    form.description = props.deviceType.description;
}

const submitForm = () => {
    if (!props.deviceType) {
        form.post(route('store.device.type'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('type_name', 'description'),
                emit('addDeviceType');
            },
            onError: (errors) => {
                if (errors.type_name) {
                    alert('addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const deviceTypeId = props.deviceType.id;
        form.put(route('update.device.type', { id: deviceTypeId }), {
            preserveScroll: true,
            onSuccess: () =>  {
                form.data(),
                emit('updateDeviceType');
            },
            onError: (errors) => {
                if (errors.type_name) {
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
        'addDeviceType', 
        'updateDeviceType'
    ]
);
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div>
                    <InputLabel for="type_name" value="Type Name" />
                    <TextInput id="type_name" type="text" class="mt-1 block w-full" v-model="form.type_name"
                        placeholder="Type Name" required autofocus />
                    <InputError class="mt-2" :message="form.errors.type_name" />
                </div>
                <div>
                    <InputLabel for="description" value="Description" />
                    <textarea id="description" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        v-model="form.description" placeholder="Description" required />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.deviceType ? 'Update' : 'Save' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>