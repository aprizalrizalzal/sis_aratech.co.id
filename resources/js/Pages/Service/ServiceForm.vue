<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DropdownSelect from '@/Components/DropdownSelect.vue'
import DateTimePicker from '@/Components/DateTimePicker.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    customer_id: '',
    device_id: '',
    date_received: '',
    items_brought: '',
    estimated_completion: '',
    status: '',
});

const statusOptions = ref([
    { id: '1', name: 'Received' },
    { id: '2', name: 'In Progress' },
    { id: '3', name: 'Completed' },
    { id: '4', name: 'Delivered' },
]);

const props = defineProps({
    customers: {
        type: Array,
        required: true
    },
    devices: {
        type: Array,
        required: true
    },
    service: Object,
    customer: Object,
    device: Object,
});

if (props.service) {
    form.customer_id = props.service.customer_id;
    form.device_id = props.service.device_id;
    form.date_received = props.service.date_received;
    form.items_brought = props.service.items_brought;
    form.estimated_completion = props.service.estimated_completion;
    form.status = props.service.status;
}

const submitForm = () => {
    if (!props.service) {
        form.post(route('store.service'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.date_received || errors.items_brought || errors.estimated_completion || errors.status) {
                    alert('Service addition failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    } else {
        const serviceId = props.service.id;
        form.put(route('update.service', { id: serviceId }), {
            preserveScroll: true,
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.date_received || errors.items_brought || errors.estimated_completion || errors.status) {
                    alert('Service update failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    }

};
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div v-if="!props.customer">
                    <DropdownSelect id="customer_id" label="Customer Email" optionProperty="email" valueProperty="id"
                        :options="customers" v-model="form.customer_id" placeholder="Select Email" />
                </div>
                <div v-if="!props.device">
                    <DropdownSelect id="device_id" label="Serial Number" optionProperty="serial_number"
                        valueProperty="id" :options="devices" v-model="form.device_id"
                        placeholder="Select Serial Number" />
                </div>
                <div>
                    <DateTimePicker id="date_received" label="Appointment Date & Time" v-model="form.date_received"
                        placeholder="Select Date and Time" />

                </div>
                <div>
                    <InputLabel class="mt-3" for="items_brought" value="Items Brought" />
                    <TextInput id="items_brought" type="text" class="mt-1 block w-full" v-model="form.items_brought"
                        placeholder="Items Brought" required autofocus />
                    <InputError class="mt-3" :message="form.errors.items_brought" />
                </div>
                <div>
                    <DateTimePicker id="estimated_completion" label="Appointment Date & Time"
                        v-model="form.estimated_completion" placeholder="Select Date and Time" />
                </div>
                <div>
                    <DropdownSelect id="status" label="Status" :options="statusOptions" optionProperty="name"
                        valueProperty="name" v-model="form.status" placeholder="Select Status" />
                </div>
                <div>
                    <PrimaryButton class="mt-3">
                        {{ props.service ? 'Update Service' : 'Add Service' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.service ? 'Service update successfully!' : 'Service added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>