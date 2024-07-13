<script setup>
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
    notes: '',
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

if (props.service) {
    form.customer_id = props.service.customer_id;
    form.device_id = props.service.device_id;
    form.status_warranty_service_id = props.service.status_warranty_service_id;
    form.date_received = props.service.date_received;
    form.problem_description = props.service.problem_description;
    form.estimated_completion = props.service.estimated_completion;
    form.items_brought = props.service.items_brought;
    form.status_service_id = props.service.status_service_id;
    form.notes = props.service.notes;
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
                if (errors.customer_id || errors.device_id || errors.date_received || errors.status_warranty_service_id || errors.problem_description || errors.estimated_completion || errors.items_brought || errors.status_service_id) {
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <InputLabel class="mt-3" for="customer_id" value="Customer Phone" />
                        <div class="flex items-center justify-between">
                            <div v-if="props.service" class="me-4 w-full">
                                <span>{{ props.service.customer.phone }}</span>
                            </div>
                            <DropdownSelect id="customer_id" optionProperty="phone" valueProperty="id"
                                :options="customers" v-model="form.customer_id" placeholder="Select Phone"
                                class="w-full" />
                        </div>
                        <InputError class="mt-3" :message="form.errors.customer_id" />
                        <InputLabel class="mt-3" for="device_id" value="Serial Number" />
                        <div class="flex items-center justify-between">
                            <div v-if="props.service" class="me-4 w-full">
                                <span>{{ props.service.device.serial_number }}</span>
                            </div>
                            <DropdownSelect id="device_id" optionProperty="serial_number" valueProperty="id"
                                :options="devices" v-model="form.device_id" placeholder="Select Serial Number"
                                class="w-full" />
                        </div>
                        <InputError class="mt-3" :message="form.errors.device_id" />
                        <InputLabel class="mt-3" for="status_warranty_service_id" value="Status Warranty" />
                        <div class="flex items-center justify-between">
                            <div v-if="props.service" class="me-4 w-full">
                                <span>{{ props.service.status_warranty_service.status }}</span>
                            </div>
                            <DropdownSelect id="status_warranty_service_id" optionProperty="status" valueProperty="id"
                                :options="statusWarrantyServices" v-model="form.status_warranty_service_id"
                                placeholder="Select Status Warranty" class="w-full" />
                        </div>
                        <InputError class="mt-3" :message="form.errors.status_warranty_service_id" />
                        <div>
                            <DateTimePicker id="date_received" class="mt-3" label="Date Received"
                                v-model="form.date_received" placeholder="Select Date and Time" />
                            <InputError class="mt-3" :message="form.errors.date_received" />
                        </div>
                    </div>
                    <div>
                        <div>
                            <InputLabel class="mt-3" for="problem_description" value="Problem Description" />
                            <TextInput id="problem_description" type="text"
                                class="mt-2 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                                v-model="form.problem_description" placeholder="Problem Description" required />
                            <InputError class="mt-3" :message="form.errors.problem_description" />
                        </div>
                        <div>
                            <DateTimePicker id="estimated_completion" class="mt-3" label="Estimated Completion"
                                v-model="form.estimated_completion" placeholder="Select Date and Time" />
                            <InputError class="mt-3" :message="form.errors.estimated_completion" />
                        </div>
                        <div>
                            <InputLabel class="mt-3" for="items_brought" value="Items Brought" />
                            <TextInput id="items_brought" type="text" class="mt-2 block w-full"
                                v-model="form.items_brought" placeholder="Items Brought" required autofocus />
                            <InputError class="mt-3" :message="form.errors.items_brought" />
                        </div>
                        <InputLabel class="mt-3" for="status_service_id" value="Status" />
                        <div class="flex items-center justify-between">
                            <div v-if="props.service" class="me-4 w-full">
                                <span>{{ props.service.status_service.status }}</span>
                            </div>
                            <DropdownSelect id="status_service_id" optionProperty="status" valueProperty="id"
                                :options="statusServices" v-model="form.status_service_id" placeholder="Select Status"
                                class="w-full" />
                        </div>
                        <InputError class="mt-3" :message="form.errors.status_service_id" />
                    </div>
                </div>
                <div>
                    <InputLabel class="mt-3" for="notes" value="Notes" />
                    <textarea id="notes" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        v-model="form.notes" placeholder="Notes" required />
                    <InputError class="mt-3" :message="form.errors.notes" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
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