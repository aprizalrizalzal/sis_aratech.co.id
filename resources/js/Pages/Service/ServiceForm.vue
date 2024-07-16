<script setup>
import { ref, watch } from 'vue';
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
    status_warranty_service_id: '',
    date_received: '',
    problem_description: '',
    estimated_completion: '',
    items_brought: '',
    status_service_id: '',
});

const props = defineProps({
    customers: Array,
    devices: Array,

    printService: String,

    service: Object,

    customer: Object,
    device: Object,

    statusWarrantyServices: Array,
    statusServices: Array,
});

const customerEmail = ref('');
const deviceModel = ref('');

if (props.service) {
    form.customer_id = props.service.customer_id;
    form.device_id = props.service.device_id;
    form.status_warranty_service_id = props.service.status_warranty_service_id;
    form.date_received = props.service.date_received;
    form.problem_description = props.service.problem_description;
    form.estimated_completion = props.service.estimated_completion;
    form.items_brought = props.service.items_brought;
    form.status_service_id = props.service.status_service_id;
    const selectedCustomer = props.customers.find(customer => customer.id === form.customer_id);
    const selectedDevice = props.devices.find(device => device.id === form.device_id);
    if (selectedCustomer) {
        customerEmail.value = selectedCustomer.user.email;
    }
    if (selectedDevice) {
        deviceModel.value = selectedDevice.model;
    }
}

const submitForm = () => {
    if (!props.service) {
        form.post(route('store.service'), {
            preserveScroll: true,
            resetOnSuccess: false,
            onSuccess: (page) => {
                form.reset();
                const printService = page.props.printService;
                if (printService) {
                    window.open(printService, '_blank');
                };
            },
            onError: (errors) => {
                if (errors.customer_id || errors.device_id || errors.date_received || errors.status_warranty_service_id || errors.problem_description || errors.estimated_completion || errors.items_brought || errors.status_service_id) {
                    alert('addition failed!');
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
                if (errors.customer_id || errors.device_id || errors.date_received || errors.status_warranty_service_id || errors.problem_description || errors.estimated_completion || errors.items_brought || errors.status_service_id) {
                    alert('update failed!');
                } else {
                    console.error('An error occurred:', errors);
                }
            }
        });
    }
};

watch(() => form.customer_id, (newCustomerId) => {
    const selectedCustomer = props.customers.find(customer => customer.id === newCustomerId);
    if (selectedCustomer) {
        customerEmail.value = selectedCustomer.user.email;
    }
});

watch(() => form.device_id, (newDeviceId) => {
    const selectedDevice = props.devices.find(device => device.id === newDeviceId);
    if (selectedDevice) {
        deviceModel.value = selectedDevice.model;
    }
});
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div>
                    <DropdownSelect id="customer_id" label="Customer Phone" optionProperty="phone" valueProperty="id"
                        :options="customers" v-model="form.customer_id"
                        :placeholder='props.service ? props.service.customer.phone : "Select Phone"' class="w-full" />
                    <InputError class="mt-2" :message="form.errors.customer_id" />
                </div>
                <div v-if="form.customer_id">
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="text" class="mt-1 block w-full" :placeholder="customerEmail" disabled />
                </div>
                <hr v-if="form.customer_id">
                <div>
                    <DropdownSelect id="device_id" label="Serial Number" optionProperty="serial_number"
                        valueProperty="id" :options="devices" v-model="form.device_id"
                        :placeholder='props.service ? props.service.device.serial_number : "Select Serial Number"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.device_id" />
                </div>
                <div v-if="form.device_id">
                    <InputLabel for="model" value="Model" />
                    <TextInput id="model" type="text" class="mt-1 block w-full" :placeholder="deviceModel" disabled />
                </div>
                <hr v-if="form.device_id">
                <div>
                    <DropdownSelect id="status_warranty_service_id" label="Status Warranty" optionProperty="status"
                        valueProperty="id" :options="statusWarrantyServices" v-model="form.status_warranty_service_id"
                        :placeholder='props.service ? props.service.status_warranty_service.status : "Select Status Warranty"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.status_warranty_service_id" />
                </div>
                <div>
                    <DateTimePicker id="date_received" class="mt-3" label="Date Received" v-model="form.date_received"
                        placeholder="Select Date and Time" />
                    <InputError class="mt-2" :message="form.errors.date_received" />
                </div>
                <div>
                    <InputLabel for="problem_description" value="Problem Description" />
                    <TextInput id="problem_description" type="text"
                        class="mt-1 block w-full"
                        v-model="form.problem_description" placeholder="Problem Description" required />
                    <InputError class="mt-2" :message="form.errors.problem_description" />
                </div>
                <div>
                    <DateTimePicker id="estimated_completion" class="mt-3" label="Estimated Completion"
                        v-model="form.estimated_completion" placeholder="Select Date and Time" />
                    <InputError class="mt-2" :message="form.errors.estimated_completion" />
                </div>
                <div>
                    <InputLabel for="items_brought" value="Items Brought" />
                    <TextInput id="items_brought" type="text" class="mt-1 block w-full" v-model="form.items_brought"
                        placeholder="Items Brought" required autofocus />
                    <InputError class="mt-2" :message="form.errors.items_brought" />
                </div>
                <InputLabel for="status_service_id" value="Status" />
                <div>
                    <DropdownSelect id="status_service_id" optionProperty="status" valueProperty="id"
                        :options="statusServices" v-model="form.status_service_id"
                        :placeholder='props.service ? props.service.status_service.status : "Select Status"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.status_service_id" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.service ? 'Update' : 'Save' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.service ? 'update successfully!' : 'added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>