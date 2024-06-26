<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    serviceDetail: Object,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

onMounted(() => {
    setTimeout(() => {
        window.print();
        window.close();
    }, 500);
});
</script>
<template id="print-service-detail">

    <Head title="Service Detail Print" />
    <div v-for="header in $page.props.headers" :key="header.id" class="flex items-stretch mb-2 gap-2 text-sm/relaxed">
        <div>
            <ApplicationLogo class="block h-14 w-14" />
        </div>
        <div class="mt-auto">
            <p class="font-bold text-lg">SIService - {{ header.company }}</p>
            <p>{{ header.description }}</p>
        </div>
    </div>
    <hr>
    <table class="table-auto w-full my-2">
        <tbody>
            <tr class="font-bold bg-green-50">
                <td class=" text-green-900">
                    Service Detail Code
                </td>
                <td>
                    {{ serviceDetail.service_detail_code }}
                </td>
            </tr>
            <tr class="font-bold bg-green-50">
                <td class="text-green-900">
                    Service Code
                </td>
                <td>
                    {{ serviceDetail.service.service_code }}
                </td>
            </tr>
            <tr>
                <td class="text-green-900">
                    Technician
                </td>
                <td>
                    {{ serviceDetail.user.name }}
                </td>
            </tr>
            <tr>
                <td class="text-green-900">
                    Repair Description
                </td>
                <td>
                    {{ serviceDetail.repair_description }}
                </td>
            </tr>
            <tr class="font-bold text-green-900">
                <td class="text-green-900">
                    Cost
                </td>
                <td>
                    {{ formatCurrency(serviceDetail.cost) }}
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div class="my-2 text-sm/relaxed">
        <p>Notes! <span class="font-bold text-green-800">Cost</span> tidak termasuk harga Spare Part jika ada
            penggantian selama service.
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
        padding: 8mm;
    }

    table {
        font-size: 75%;
        width: 100%;
    }

    .border {
        border: 0.5px solid #A9A9A9A9;
        border-radius: 8px;
    }

    #footer {
        font-size: 75%;
    }
}
</style>