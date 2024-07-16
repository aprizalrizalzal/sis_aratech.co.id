<script setup>
import { useForm } from '@inertiajs/vue3';
import DropdownSelect from '@/Components/DropdownSelect.vue'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    service_detail_id: '',
    spare_part_id: '',
    quantity: '',
});

const props = defineProps({
    serviceDetails: Array,
    spareParts: Array,

    partUsage: Object,
    serviceDetail: Object,
    sparePart: Object,
});

if (props.partUsage) {
    form.service_detail_id = props.partUsage.service_detail_id;
    form.spare_part_id = props.partUsage.spare_part_id;
    form.quantity = props.partUsage.quantity;
}

const submitForm = () => {
    if (!props.partUsage) {
        form.post(route('store.part.usage'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.service_detail_id || errors.spare_part_id || errors.quantity) {
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
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.service_detail_id || errors.spare_part_id || errors.quantity) {
                    alert('Part usage update failed!');
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
                <div>
                    <DropdownSelect id="service_detail_id" label="Service Detail" optionProperty="service_detail_code"
                        valueProperty="id" :options="serviceDetails" v-model="form.service_detail_id"
                        :placeholder='props.serviceDetail ? props.serviceDetail.service_detail_code : "Select Service Detail Code"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.service_detail_id" />
                </div>
                <div>
                    <DropdownSelect id="spare_part_id" label="Spare Part" optionProperty="name" valueProperty="id"
                        :options="spareParts" v-model="form.spare_part_id"
                        :placeholder='props.partUsage ? props.partUsage.spare_part.name : "Select Spare Part"'
                        class="w-full" />
                    <InputError class="mt-2" :message="form.errors.spare_part_id" />
                </div>
                <div>
                    <InputLabel for="quantity" value="Quantity" />
                    <TextInput id="quantity" type="text" class="mt-1 block w-full" v-model="form.quantity"
                        placeholder="Quantity" required autofocus />
                    <InputError class="mt-2" :message="form.errors.quantity" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.partUsage ? 'Update' : 'Save' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.partUsage ? 'Part Usage update successfully!' : 'Part Usage added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>