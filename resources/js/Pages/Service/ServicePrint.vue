<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const props = defineProps({
    service: Object,
});

const currentUrl = computed(() => {
    const url = new URL(window.location.href);
    return `${url.host}`;
});

const footers = usePage().props.footers;

const contactFooters = computed(() => {
    return footers.filter(footer => footer.type === 'Contact');
});

onMounted(() => {
    setTimeout(() => {
        window.print();
        window.close();
    }, 500);
});
</script>

<template id="print-template">

    <Head title="Service Print" />
    <div v-for="header in $page.props.headers" :key="header.id" class="flex items-stretch mt-4 gap-2 text-sm/relaxed">
        <div>
            <ApplicationLogo class="block h-24 w-24" />
        </div>
        <div class="mt-auto">
            <p class="font-bold text-lg">SIService - {{ header.company }}</p>
            <p>{{ header.description }}</p>
            <div v-for="footer in contactFooters" :key="footer.id">
                <span>{{ footer.value }}</span>
            </div>
        </div>
    </div>
    
    <br>
    <table class="table-auto w-full">
        <tbody>
            <tr class="font-bold bg-green-50 ">
                <td class=" text-green-900">
                    Service Code
                </td>
                <td colspan="3">
                    {{ service.service_code }}
                </td>
            </tr>
            <tr>
                <td class=" text-green-900">
                    Customer
                </td>
                <td>
                    {{ service.customer.user.name }}
                </td>
                <td class=" text-green-900">
                    Phone
                </td>
                <td >
                    {{ service.customer.phone }}
                </td>
            </tr>
            <tr>
                <td class=" text-green-900">
                Alamat
                </td>
                <td >
                    {{ service.customer.address }}
                </td>
                <td class=" text-green-900">
                    Model
                </td>
                <td >
                    {{ service.device.model }}
                </td>
            </tr>
            <tr>
                <td class=" text-green-900">
                    Serial Number
                </td>
                <td >
                    {{ service.device.serial_number }}
                </td>
                <td class=" text-green-900">
                    Warranty Status
                </td>
                <td >
                    Out Warranty
                </td>
            </tr>
            <tr>
                <td class=" text-green-900">
                    Date Received
                </td>
                <td >
                    {{ service.date_received }}
                </td>
                <td class=" text-green-900">
                    Estimated Completion
                </td>
                <td >
                    {{ service.estimated_completion }}
                </td>
            </tr>
            <tr>
                <td class=" text-green-900">
                    Problem Description
                </td>
                <td >
                    {{ service.problem_description }}
                </td>
                <td class=" text-green-900">
                    Items Brought
                </td>
                <td >
                    {{ service.items_brought }}
                </td>
            </tr>
            <tr class="font-bold bg-green-50">
                <td class=" text-green-900">
                    Status
                </td>
                <td colspan="3">
                    {{ service.status }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <div id="footer" class="flex gap-4 justify-between text-sm/relaxed text-left">
        <div class="flex flex-col gap-10">
            <p>Admin</p>
            <span>Widiya</span>
        </div>
        <div class="flex flex-col gap-10">
            <p>Technician</p>
            <span>Aprizal</span>
        </div>
        <div class="flex flex-col gap-10">
            <p>Customer</p>
            <span>Ibnu</span>
        </div>
        <div class="flex flex-col items-center border px-2">
            <p>Notes!</p>
            <span>Pelayanan service Senin-Sabtu, pukul 08.00-17.00 WITA.</span>
            <span>Barang yang tidak diambil dalam 7 hari tidak lagi menjadi tanggung jawab kami.</span>
            <span>Harap menunjukkan nota service saat pengambilan barang.</span>
        </div>
    </div>
    <div class="mt-2 text-sm/relaxed text-left">
        <span>Kunjungi! </span><a target="_blank" rel="noopener noreferrer" class="text-green-800 font-bold" :href="currentUrl">{{currentUrl }}</a> gunakan Email: 
        <span class="font-bold text-green-800">{{ service.customer.user.email }}</span> dan Password:
        <span class="font-bold text-green-800">password</span> untuk melihat perkembangan device yang diservice.
    </div>
</template>

<style scoped>
@media print {
    @page {
        size: A4;
        margin: 4;
    }

    body {
        width: 210mm;
        height: 297mm;
        margin: 2 auto;
        padding: 8mm;
    }

    table {
        font-size: 80%;
        width: 100%;
    }

    .border {
        border: 0.5px solid #000;
    }

    #footer {
        font-size: 80%;
    }
}
</style>
