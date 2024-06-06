<script setup>
import CustomerForm from '@/Pages/Customer/CustomerForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    customers: {
        type: Array,
        required: true
    }
});

const showingModelCustomerUpdate = ref(false);
const selectedCustomer = ref(null);

const showModalCustomerUpdate = (customer) => {
    selectedCustomer.value = customer;
    showingModelCustomerUpdate.value = true;
};

const confirmingCustomerDeletion = ref(false);
const form = useForm({
    id: null,
});

const confirmCustomerDeletion = (customerId) => {
    confirmingCustomerDeletion.value = true;
    form.id = customerId;
};

const deleteCustomer = () => {
    form.delete(route('destroy.customer'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: (errors) => {
            if (errors) {
                closeModal();
            } else {
                console.error('There was an error!', errors);
            }
        }
    });
};

const closeModal = () => {
    confirmingCustomerDeletion.value = false;
};

</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">#</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Email</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Phone</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(customer, index) in customers" :key="customer.id" class="hover:bg-green-100">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ index + 1 }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ customer.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ customer.email }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ customer.phone }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalCustomerUpdate(customer)" class="m-2">Update</SecondaryButton>
                        <DangerButton @click="confirmCustomerDeletion(customer.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
        <Modal v-model:show="showingModelCustomerUpdate">
            <div class="m-6">
                <div class="flex justify-end">
                    <DangerButton @click="showingModelCustomerUpdate = false">X</DangerButton>
                </div>
                <CustomerForm :customer="selectedCustomer" />
            </div>
        </Modal>
        <Modal :show="confirmingCustomerDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-green-900">
                    Are you sure you want to delete your customer?
                </h2>

                <p class="mt-1 text-sm text-green-600">
                    Once your customer is deleted, all of its resources and data will be permanently deleted.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteCustomer">
                        Delete customer
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
