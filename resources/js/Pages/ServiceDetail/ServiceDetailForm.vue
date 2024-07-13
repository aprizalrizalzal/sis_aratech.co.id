<script setup>
import { ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import DropdownSelect from '@/Components/DropdownSelect.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const { auth } = usePage().props;
const userId = ref(auth.user.id);

const form = useForm({
    user_id: userId.value,
    service_id: '',
    status: '',
    repair_description: '',
    cost: '',
    notes: '',
});

const props = defineProps({
    users: Array,
    services: Array,

    statusServices: Array,

    printServiceDetail: String,

    serviceDetail: Object,

    user: Object,
    service: Object,
});

const serviceStatus = ref('');

const updateServiceStatus = (serviceId) => {
    if (props.services) {
        const selectedService = props.services.find(service => service.id === serviceId);
        if (selectedService) {
            serviceStatus.value = selectedService.status;
            form.status = selectedService.status;
        }
    } else {
        serviceStatus.value = props.service.status;
        form.status = props.service.status;
    }

};

if (props.serviceDetail) {
    form.user_id = props.serviceDetail.user_id;
    form.service_id = props.serviceDetail.service_id;
    form.repair_description = props.serviceDetail.repair_description;
    form.cost = props.serviceDetail.cost;
    form.notes = props.serviceDetail.notes;
    updateServiceStatus(props.serviceDetail.service_id);
}

watch(() => form.service_id, (newServiceId) => {
    updateServiceStatus(newServiceId);
});

const submitForm = () => {
    if (!props.serviceDetail) {
        form.post(route('store.service.detail'), {
            preserveScroll: true,
            onSuccess: (page) => {
                form.reset();
                const printServiceDetail = page.props.printServiceDetail;
                if (printServiceDetail) {
                    window.open(printServiceDetail, '_blank');
                };
                console.log('printServiceDetail', printServiceDetail);
            },
            onError: (errors) => {
                if (errors.user_id || errors.service_id || errors.repair_description || errors.cost || errors.notes) {
                    alert('Service detail addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const serviceDetailId = props.serviceDetail.id
        form.put(route('update.service.detail', { id: serviceDetailId }), {
            preserveScroll: true,
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.user_id || errors.service_id || errors.repair_description || errors.cost || errors.notes) {
                    alert('Service detail update failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
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
                <div v-if="!props.user" class="hidden">
                    <InputLabel class="mt-3" for="user_id" value="Technician" />
                    <TextInput id="user_id" type="text" class="mt-1 block w-full pointer-events-none bg-green-50"
                        v-model="form.user_id" placeholder="Email Technician" required autofocus />
                    <InputError class="mt-3" :message="form.errors.user_id" />
                </div>
                <InputLabel class="mt-3" for="service_id" value="Service Code" />
                <div class="flex items-center justify-between">
                    <div v-if="props.serviceDetail" class="me-4 w-full">
                        <span v-if="form.service_id">{{ props.service.service_code }}</span>
                    </div>
                    <DropdownSelect id="service_id" optionProperty="service_code" valueProperty="id" :options="services"
                        v-model="form.service_id" placeholder="Service Code" class="w-full" />
                    <InputError class="mt-3" :message="form.errors.service_id" />
                </div>
                <div v-if="form.service_id">
                    <InputLabel class="mt-3" for="status_service_id" value="Status" />
                    <div class="flex items-center justify-between">
                        <div v-if="form.service_id" class="me-4 w-full">
                            <span v-if="form.service_id">{{
                                props.serviceDetail.service.status_service.status
                                }}</span>
                        </div>
                        <DropdownSelect id="status_service_id" optionProperty="status" valueProperty="id"
                            :options="statusServices" v-model="form.status_service_id" placeholder="Select Status"
                            class="w-full" />
                        <InputError class="mt-3" :message="form.errors.status_service_id" />
                    </div>
                </div>
                <div>
                    <InputLabel class="mt-3" for="repair_description" value="Repair Description" />
                    <TextInput id="repair_description" type="text"
                        class="mt-1 block w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
                        v-model="form.repair_description" placeholder="Repair Description" required />
                    <InputError class="mt-3" :message="form.errors.repair_description" />
                </div>
                <div>
                    <InputLabel class="mt-3" for="cost" value="Cost" />
                    <TextInput id="cost" type="text" class="mt-1 block w-full" v-model="form.cost" placeholder="Cost"
                        required />
                    <InputError class="mt-3" :message="form.errors.cost" />
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
                        {{ props.user ? 'Update Service Detail' : 'Add Service Detail' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.service ? 'Service Detail update successfully!' : 'Service Detail added successfully!'
                        }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
