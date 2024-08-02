<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DropdownSelect from '@/Components/DropdownSelect.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    service_detail_id: '',
    status_service_id: '',
    spare_part_id: '',
    quantity: '',
});

const props = defineProps({
    serviceDetails: Array,

    statusServices: Array,

    spareParts: Array,

    partUsage: Object,
    serviceDetail: Object,
    sparePart: Object,
});

const technicianName = ref('');
const technicianEmail = ref('');
const technicianPhone = ref('');
const serviceCode = ref('');
const serviceName = ref('');
const serviceEmail = ref('');
const servicePhone = ref('');
const serviceStatus = ref('');

if (props.partUsage) {
    form.service_detail_id = props.partUsage.service_detail_id;
    form.spare_part_id = props.partUsage.spare_part_id;
    form.quantity = props.partUsage.quantity;
    const selectedServiceDetail = props.serviceDetails.find(serviceDetail => serviceDetail.id === form.service_detail_id);
    if (selectedServiceDetail) {
        technicianName.value = selectedServiceDetail.user.name;
        technicianEmail.value = selectedServiceDetail.user.email;
        technicianPhone.value = selectedServiceDetail.user.customer.phone;
        serviceCode.value = selectedServiceDetail.service.service_code;
        serviceName.value = selectedServiceDetail.service.customer.user.name;
        serviceEmail.value = selectedServiceDetail.service.customer.user.email;
        servicePhone.value = selectedServiceDetail.service.customer.phone;
        serviceStatus.value = selectedServiceDetail.service.status_service.status;
        form.status_service_id = selectedServiceDetail.service.status_service.id;
    }
}

watch(() => form.service_detail_id, (newServiceDetailId) => {
    const selectedServiceDetail = props.serviceDetails.find(serviceDetail => serviceDetail.id === newServiceDetailId);
    if (selectedServiceDetail) {
        technicianName.value = selectedServiceDetail.user.name;
        technicianEmail.value = selectedServiceDetail.user.email;
        technicianPhone.value = selectedServiceDetail.user.customer.phone;
        serviceCode.value = selectedServiceDetail.service.service_code;
        serviceName.value = selectedServiceDetail.service.customer.user.name;
        serviceEmail.value = selectedServiceDetail.service.customer.user.email;
        servicePhone.value = selectedServiceDetail.service.customer.phone;
        serviceStatus.value = selectedServiceDetail.service.status_service.status;
        form.status_service_id = selectedServiceDetail.service.status_service.id;
    }
});

const submitForm = () => {
    if (!props.partUsage) {
        form.post(route('store.part.usage'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('quantity'),
                emit('addPartUsage');
            },
            onError: (errors) => {
                if (errors.service_detail_id || errors.status_service_id || errors.spare_part_id || errors.quantity) {
                    alert('Part usage addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const partUsageId = props.partUsage.id;
        form.put(route('update.part.usage', { id: partUsageId }), {
            preserveScroll: true,
            onSuccess: () => {
                form.data(),
                emit('updatePartUsage');
            },
            onError: (errors) => {
                if (errors.service_detail_id || errors.status_service_id || errors.spare_part_id || errors.quantity) {
                    alert('Part usage update failed!');
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
        'addPartUsage', 
        'updatePartUsage'
    ]
);
</script>

<template>
    <div class="relative flex w-full flex-1 items-stretch">
        <div class="w-full">
            <form @submit.prevent="submitForm" class="mt-3 space-y-3">
                <div>
                    <DropdownSelect id="service_detail_id" label="Service Detail Code" optionProperty="service_detail_code"
                        valueProperty="id" :options="serviceDetails" v-model="form.service_detail_id"
                        :placeholder='props.serviceDetail ? props.serviceDetail.service_detail_code : "Select Service Detail Code"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.service_detail_id" />
                </div>
                <div v-if="form.service_detail_id">
                    <InputLabel for="name" value="Technician Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" :placeholder="technicianName"
                        disabled />
                </div>
                <div v-if="form.service_detail_id">
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="text" class="mt-1 block w-full" :placeholder="technicianEmail"
                        disabled />
                </div>
                <div v-if="form.service_detail_id">
                    <InputLabel for="phone" value="Phone" />
                    <TextInput id="phone" type="text" class="mt-1 block w-full" :placeholder="technicianPhone"
                        disabled />
                </div>
                <div v-if="form.service_detail_id">
                    <InputLabel for="service_code" value="Service Code" />
                    <TextInput id="service_code" type="text" class="mt-1 block w-full" :placeholder="serviceCode"
                        disabled />
                </div>
                <div v-if="form.service_detail_id">
                    <InputLabel for="name" value="Customer Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" :placeholder="serviceName" disabled />
                </div>
                <div v-if="form.service_detail_id">
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="text" class="mt-1 block w-full" :placeholder="serviceEmail" disabled />
                </div>
                <div v-if="form.service_detail_id">
                    <InputLabel for="phone" value="Phone" />
                    <TextInput id="phone" type="text" class="mt-1 block w-full" :placeholder="servicePhone" disabled />
                </div>
                <div v-if="form.service_detail_id">
                    <DropdownSelect id="status_service_id" label="Status" optionProperty="status" valueProperty="id"
                        :options="statusServices" v-model="form.status_service_id"
                        :placeholder='form.service_detail_id ? serviceStatus : "Select Status"' class="mt-1 block w-full" />
                    <InputError class="mt-2" :message="form.errors.status_service_id" />
                </div>
                <hr v-if="form.service_detail_id">
                <div>
                    <DropdownSelect id="spare_part_id" label="Spare Part" optionProperty="name" valueProperty="id"
                        :options="spareParts" v-model="form.spare_part_id"
                        :placeholder='props.partUsage ? props.partUsage.spare_part.name : "Select Spare Part"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.spare_part_id" />
                </div>
                <div>
                    <InputLabel for="quantity" value="Quantity" />
                    <TextInput id="quantity" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.quantity"
                        placeholder="Quantity" required autofocus />
                    <InputError class="mt-2" :message="form.errors.quantity" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.partUsage ? 'Update' : 'Save' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>