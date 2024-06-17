<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    service: Object,
});

onMounted(() => {
    window.print();
});
</script>

<template id="print-template">

    <Head title="Service Print" />
    <div class="mt-4 text-sm/relaxed">
        <p>Asli Mandiri Computer - AMITech</p>
        <p>Jl. Gajah Mada, Pagesangan, Kec. Mataram, Kota Mataram, Nusa Tenggara Bar.</p>
        <div class="flex items-center space-x-2">
            <a href="https://wa.me/6282247912220" target="_blank" rel="noopener noreferrer">0822-4791-2220</a>
            <span>/</span>
            <a href="https://wa.me/6287765889202" target="_blank" rel="noopener noreferrer">0877-6588-9202</a>
        </div>

    </div>
    <br>
    <table class="table-auto w-full">
        <tbody>
            <tr class="font-bold text-red-900">
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                    Service Code
                </td>
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                    {{ service.service_code }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Email
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.customer.user.email }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Phone
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.customer.phone }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Model
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.device.model }}
                </td>
            </tr>
            <tr class="font-bold text-red-900">
                <td class="py-2 px-4 border border-green-50 text-center">
                    Serial Number
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.device.serial_number }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Date Received
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.date_received }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Items Brought
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.items_brought }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Estimated Completion
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.estimated_completion }}
                </td>
            </tr>
            <tr class="font-bold text-green-900">
                <td class="py-2 px-4 border border-green-50 text-center">
                    Status
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ service.status }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <div class="mt-4 text-sm/relaxed">
        <p>Untuk mengeksplorasi produk kami, kunjungi <a target="_blank" rel="noopener noreferrer"
                class="text-green-800 font-bold" href="http://www.aslimandiri.com">aslimandiri.com</a>. Kunjungi juga
            <a target="_blank" rel="noopener noreferrer" class="text-green-800 font-bold"
                href="http://www.siservice-aslimandiri.com">siservice-aslimandiri.com</a>
            gunakan Email: <span class="font-bold text-green-800">{{
                service.customer.user.email }}</span> dan Password:
            <span class="font-bold text-green-800">password</span> untuk melihat perkembangan device yang diservice.
        </p>
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
        padding: 10mm;
    }

    table {
        font-size: 80%;
        width: 100%;
    }

    .border {
        border: 1px solid #000;
    }
}
</style>
