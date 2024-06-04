<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    address: '',
    phone: '',
    email: '',
});

const props = defineProps({
    customers: {
        type: Array,
        required: true
    },
    customer: Object,
});

if (props.customer) {
    form.name = props.customer.name;
    form.address = props.customer.address;
    form.phone = props.customer.phone;
    form.email = props.customer.email;
}

const submitForm = () => {
    if (!props.customer) {
        form.post(route('store.customer'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: (errors) => {
                if (errors.name || errors.address || errors.phone || errors.email) {
                    alert('Customer addition failed!');
                } else {
                    console.error('There was an error!', errors);
                }
            }
        });
    } else {
        const customerId = props.customer.id;
        form.put(route('update.customer', { id: customerId }), {
            preserveScroll: true,
            onSuccess: () => form.data(),
            onError: (errors) => {
                if (errors.name || errors.address || errors.phone || errors.email) {
                    alert('Customer update failed!');
                } else {
                    console.error('There was an error!', errors);
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
                    <InputError class="mt-3" :message="form.errors.name" />

                    <InputLabel class="mt-3" for="address" value="Address" />
                    <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address"
                        placeholder="Address" required autofocus />
                    <InputError class="mt-3" :message="form.errors.address" />

                    <InputLabel class="mt-3" for="phone" value="Phone" />
                    <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" placeholder="Phone"
                        required autofocus />
                    <InputError class="mt-3" :message="form.errors.phone" />

                    <InputLabel class="mt-3" for="email" value="Email" />
                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                        placeholder="Email" required autofocus />
                    <InputError class="mt-3" :message="form.errors.email" />
                </div>
                <div>
                    <PrimaryButton class="mt-3">
                        {{ props.customer ? 'Update Customer' : 'Add Customer' }}
                    </PrimaryButton>
                    <span v-if="form.recentlySuccessful" class="text-green-500 ml-2">
                        {{ props.customer ? 'Customer update successfully!' : 'Customer added successfully!' }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</template>
