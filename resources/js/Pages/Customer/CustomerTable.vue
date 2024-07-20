<script setup>
import CustomerForm from '@/Pages/Customer/CustomerForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

const closeModal = () => {
    showingModelCustomerUpdate.value = false;
    confirmingCustomerDeletion.value = false;
};

const currentPage = ref(1);
const itemsPerPage = 15;

const paginatedCustomers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.customers.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.customers.length / itemsPerPage);
});

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};
</script>

<template>
    <div class=" overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">No</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Name</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Phone</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300">Address</th>
                    <th class="py-4 px-4 border-b border-green-300 bg-green-300" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(customer, index) in paginatedCustomers" :key="customer.id" class="hover:bg-green-50">
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ (currentPage - 1) * itemsPerPage +
                        index + 1 }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ customer.user.name }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">{{ customer.phone }}</td>
                    <td
                        class="py-2 px-4 border-b border-green-300 text-center whitespace-nowrap overflow-x-auto text-overflow-ellipsis max-w-xs">
                        {{ customer.address }}</td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <SecondaryButton @click="showModalCustomerUpdate(customer)" class="m-2">Update</SecondaryButton>
                    </td>
                    <td class="py-2 px-4 border-b border-green-300 text-center">
                        <DangerButton @click="confirmCustomerDeletion(customer.id)" class="m-2">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-center gap-4 items-center p-6">
        <SecondaryButton @click="previousPage" :disabled="currentPage === 1">Previous</SecondaryButton>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">Next</SecondaryButton>
    </div>

    <Modal :show="showingModelCustomerUpdate">
        <div class="m-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Update Customer</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <CustomerForm :customer="selectedCustomer" />
        </div>
    </Modal>
    <Modal :show="confirmingCustomerDeletion">
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
</template>

<style scoped>
/* Custom scrollbar style for overflow-x-auto */
.overflow-x-auto::-webkit-scrollbar {
    display: none;
}

.overflow-x-auto {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
