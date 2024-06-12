<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    serviceDetail: Object,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

onMounted(() => {
    window.print();
});
</script>
<template id="print-template">

    <Head title="Service Detail Print" />
    <div class="mt-4 text-sm/relaxed">
        <p>Asli Mandiri Computer - AMITech</p>
        <p>Jl. Gajah Mada, Pagesangan, Kec. Mataram, Kota Mataram, Nusa Tenggara Bar.</p>
    </div>
    <br>
    <table class="table-auto w-full">
        <tbody>
            <tr class="font-bold text-red-900">
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                    Service Detail Code
                </td>
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                    {{ serviceDetail.service_detail_code }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Technician
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ serviceDetail.user.name }}
                </td>
            </tr>
            <tr class="font-bold text-red-900">
                <td class="py-2 px-4 border border-green-50 text-center">
                    Service Code
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ serviceDetail.service.service_code }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Problem Description
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ serviceDetail.problem_description }}
                </td>
            </tr>
            <tr>
                <td class="py-2 px-4 border border-green-50 text-center">
                    Repair Description
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ serviceDetail.repair_description }}
                </td>
            </tr>
            <tr class="font-bold text-green-900">
                <td class="py-2 px-4 border border-green-50 text-center">
                    Cost
                </td>
                <td class="py-2 px-4 border border-green-50 text-center">
                    {{ formatCurrency(serviceDetail.cost) }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <div class="mt-4 text-sm/relaxed">
        <p>Untuk mengeksplorasi berbagai produk
            kami,
            kunjungi situs
            web kami di <a target="_blank" rel="noopener noreferrer" class="text-green-800 font-bold"
                href="http://www.aslimandiri.com">www.aslimandiri.com.</a>
            Bersama kami, temukan
            solusi terbaik
            untuk segala kebutuhan teknologi Anda, di mana kepuasan Anda adalah
            prioritas kami.
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