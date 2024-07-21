<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    service: Object,
    message: String,
});

const showModal = ref(false);

const form = useForm({
    service_code: '',
});

const submitForm = () => {
    form.post(route('store.welcome'), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = true;
            form.reset;
        },
        onError: (errors) => {
            if (errors.id) {
                alert('not found');
            } else {
                const errorMessages = Object.values(errors).flat();
                alert(`${errorMessages}`);
            }
        }
    });
};

const closeModal = () => {
    showModal.value = false;
    form.reset;
};
</script>

<template>
    <div class="grid grid-cols-1 mt-4 gap-4">
        <div v-for="header in $page.props.headers" :key="header.id"
            class="flex flex-col p-8 items-start gap-2 overflow-hidden rounded-md bg-white shadow-md ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700 md:row-span-3 lg:pb-8">
            <h2 class="text-xl font-semibold text-green-900 mt-2">
                SIService - {{ header.company }}
            </h2>
            <p class="text-sm/relaxed">
                Sistem Informasi Service kami membantu Anda memantau layanan dengan mudah
                dan efisien.
            </p>
            <div class="relative flex w-full flex-1 items-stretch">
                <div class="w-full">
                    <form @submit.prevent="submitForm" class="mt-2 space-y-2">
                        <div>
                            <InputLabel for="service_code" value="Service Code" />
                            <TextInput id="service_code" type="text" class="mt-2 block w-full"
                                v-model="form.service_code" placeholder="Service Code" required autofocus />
                            <InputError class="mt-2" :message="form.errors.service_code" />
                        </div>
                        <div class="flex justify-end">
                            <PrimaryButton class="mt-2 mb-2">Search</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-sm/relaxed">Pastikan Service Code yang dimasukkan menggunakan huruf kapital agar sistem dapat
                menemukan data yang sesuai dengan benar. Contoh: <strong>DFGYHN</strong>.</p>
            <p class="text-sm/relaxed">Harap dicatat! Service Code hanya boleh menggunakan huruf kapital.</p>
        </div>
    </div>

    <Modal v-if="service" :show="showModal">
        <div class="p-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Service Details</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <table class="table-auto w-full mt-4">
                <tbody>
                    <tr class="font-bold border border-green-50 bg-green-50 text-green-900 py-2 px-4">
                        <td class="text-green-900">Service Code</td>
                        <td> {{ service.service_code }}</td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Email</td>
                        <td>{{ service.customer.user.email }}</td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Phone</td>
                        <td>{{ service.customer.phone }} </td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Address </td>
                        <td>{{ service.customer.address }} </td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Device Type</td>
                        <td>{{ service.device.device_type.type_name }}</td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Model</td>
                        <td>{{ service.device.model }}</td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Serial Number</td>
                        <td>{{ service.device.serial_number }}</td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Warranty Status </td>
                        <td>{{ service.status_warranty_service.status }} </td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Date Received</td>
                        <td>{{ service.date_received }}</td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">Estimated Completion</td>
                        <td>{{ service.estimated_completion }} </td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">
                            Problem Description
                        </td>
                        <td>
                            {{ service.problem_description }}
                        </td>
                    </tr>
                    <tr class="py-2 px-4">
                        <td class="text-green-900">
                            Items Brought
                        </td>
                        <td>
                            {{ service.items_brought }}
                        </td>
                    </tr>
                    <tr class="font-bold border border-green-50 bg-green-50 text-green-900 py-2 px-4">
                        <td class="text-green-900">
                            Status
                        </td>
                        <td>
                            {{ service.status_service.status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <div class="mt-3">
                <p class="text-sm/relaxed">Jangan lupa untuk sering cek status servis Anda agar selalu mendapatkan
                    informasi terbaru. Salam untuk Anda, semoga sehat selalu!</p>
            </div>
        </div>
    </Modal>

    <Modal v-if="message" :show="showModal">
        <div class="p-6">
            <div class="flex justify-between items-center ps-6 ms-6 text-green-900">
                <span class="font-bold text-center w-full">Service Details</span>
                <DangerButton @click="closeModal">X</DangerButton>
            </div>
            <hr class="mt-4 mb-2 border-green-100">
            <P class="font-bold text-red-900 my-4">{{ message }}</P>
            <p class="text-sm/relaxed">Pastikan Service Code yang dimasukkan menggunakan huruf kapital agar sistem dapat
                menemukan data yang sesuai dengan benar. Contoh: <strong>DFGYHN</strong>.</p>
            <p class="text-sm/relaxed">Harap dicatat! Service Code hanya boleh menggunakan huruf kapital.</p>
        </div>
    </Modal>
</template>