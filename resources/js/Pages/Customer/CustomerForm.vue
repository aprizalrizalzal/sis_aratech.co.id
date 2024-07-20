<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
});

const props = defineProps({
    customers: Array,

    customer: Object,
});

if (props.customer) {
    form.name = props.customer.user.name;
    form.email = props.customer.user.email;
    form.phone = props.customer.phone;
    form.address = props.customer.address;
}

const submitForm = () => {
    if (!props.customer) {
        form.post(route('store.customer'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.name || errors.email || errors.phone || errors.address) {
                    alert('Customer addition failed!');
                } else {
                    const errorMessages = Object.values(errors).flat();
                    alert(`${errorMessages}`);
                }
            }
        });
    } else {
        const customerId = props.customer.id;
        form.put(route('update.customer', { id: customerId }), {
            preserveScroll: true,
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.name || errors.email || errors.phone || errors.address) {
                    alert('Customer update failed!');
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
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Name"
                        required autofocus />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                        placeholder="Email" required />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div>
                    <InputLabel for="phone" value="Phone" />
                    <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" placeholder="Phone"
                        required />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
                <div>
                    <InputLabel for="address" value="Address" />
                    <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address"
                        placeholder="Address" required />
                    <InputError class="mt-2" :message="form.errors.address" />
                </div>
                <div>
                    <PrimaryButton class="mt-6 mb-3">
                        {{ props.customer ? 'Update' : 'Save' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-4">
                        {{ props.customer ? 'Customer update successfully!' : 'Customer added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
