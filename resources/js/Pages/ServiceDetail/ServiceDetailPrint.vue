<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const footers = usePage().props.footers;

const contactFooters = computed(() => {
    return footers.filter(footer => footer.type_footer.type === 'Contact');
});

const props = defineProps({
    serviceDetail: Object,
    partUsages: Array,
});

const serviceDetailTotal = computed(() => {
    const sparePartsTotal = props.partUsages.reduce((total, partUsage) => {
        const price = parseFloat(partUsage.spare_part.price);
        return total + (isNaN(price) ? 0 : price);
    }, 0);

    const serviceCost = parseFloat(props.serviceDetail.cost);

    const total = sparePartsTotal + serviceCost

    return total;
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

onMounted(() => {
    setTimeout(() => {
        window.print();
    }, 500);
});
</script>
<template id="print-service-detail">
    <div class="m-2 px-2">

        <Head :title='"Service Detail " + props.serviceDetail.service_detail_code' />
        <div v-for="header in $page.props.headers" :key="header.id"
            class="flex items-stretch mb-2 gap-2 text-sm/relaxed">
            <div>
                <ApplicationLogo class="block h-20 w-20" />
            </div>
            <div id="footer" class="mt-auto">
                <p class="font-bold text-lg">SIService - {{ header.company }}</p>
                <p>{{ header.description }}</p>
                <div class="flex">
                    <div v-for="(footer, index) in contactFooters" :key="footer.id">
                        <p> {{ footer.value }} <span class="font-bold" v-if="index !== contactFooters.length - 1">/</span></p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <table class="table-auto w-full my-2">
            <tbody>
                <tr class="font-bold bg-green-50">
                    <td class=" text-green-900"> Service Detail Code </td>
                    <td> {{ serviceDetail.service_detail_code }} </td>
                </tr>
                <tr>
                    <td class="text-green-900">Email Technician </td>
                    <td> {{ serviceDetail.user.email }} </td>
                </tr>
                <tr class="font-bold bg-green-50 ">
                    <td class=" text-green-900">Service Code </td>
                    <td>{{ serviceDetail.service.service_code }} </td>
                </tr>
                <tr>
                    <td class=" text-green-900">Name</td>
                    <td>{{ serviceDetail.service.customer.user.name }} </td>
                </tr>
                <tr>
                    <td class=" text-green-900">Email / Phone</td>
                    <td>{{ serviceDetail.service.customer.user.email }}<span> / </span>{{
                        serviceDetail.service.customer.phone }} </td>
                </tr>
                <tr>
                    <td class=" text-green-900">Address </td>
                    <td>{{ serviceDetail.service.customer.address }} </td>
                </tr>
                <tr>
                    <td class=" text-green-900">Device Type / Model</td>
                    <td>{{ serviceDetail.service.device.device_type.type_name }}<span> / </span>{{
                        serviceDetail.service.device.model }}</td>
                </tr>
                <tr>
                    <td class=" text-green-900">Serial Number / Warranty Status </td>
                    <td>{{ serviceDetail.service.device.serial_number }}<span> / </span>{{
                        serviceDetail.service.status_warranty_service.status }} </td>
                </tr>
                <tr>
                    <td class=" text-green-900">Date Received / Estimated Completion </td>
                    <td>{{ serviceDetail.service.date_received }}<span> / </span>{{
                        serviceDetail.service.estimated_completion }} </td>
                </tr>
                <tr>
                    <td class=" text-green-900">Problem Description </td>
                    <td>{{ serviceDetail.service.problem_description }} </td>
                </tr>
                <tr>
                    <td class=" text-green-900">Items Brought </td>
                    <td>{{ serviceDetail.service.items_brought }} </td>
                </tr>
                <tr class="font-bold bg-green-50">
                    <td class=" text-green-900">Status </td>
                    <td>{{ serviceDetail.service.status_service.status }} </td>
                </tr>
                <tr>
                    <td class="text-green-900"> Repair Description </td>
                    <td> {{ serviceDetail.repair_description }} </td>
                </tr>
                <tr class="font-bold bg-green-50">
                    <td class="text-green-900"> Spare Part</td>
                    <td class="text-green-900"> Price</td>
                </tr>
                <tr v-for="(partUsage, index) in partUsages" :key="partUsage.id">
                    <td class="text-green-900"> {{ index + 1 }}. {{ partUsage.spare_part.name }} </td>
                    <td class="text-green-900"> {{ formatCurrency(partUsage.spare_part.price) }} </td>
                </tr>
                <tr class="font-bold bg-green-50">
                    <td class="text-green-900"> Cost </td>
                    <td> {{ formatCurrency(serviceDetail.cost) }} </td>
                </tr>
                <tr class="font-bold">
                    <td class="text-green-900"> Total </td>
                    <td> {{ formatCurrency(serviceDetailTotal) }} </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div id="footer" class="flex gap-4 my-2 justify-between text-sm/relaxed text-left">
            <div class="flex flex-col gap-10">
                <p>Technician</p>
                <span>{{ $page.props.auth.user.name }}</span>
            </div>
            <div class="flex flex-col gap-10">
                <p>Customer</p>
                <span>{{ serviceDetail.service.customer.user.name }}</span>
            </div>
            <div class="flex flex-col items-left border px-2 mx-1">
                <p class="font-bold">Notes!</p>
                {{ serviceDetail.notes }}
            </div>
        </div>
        <hr>
        <div id="footer" class="my-2 text-sm/relaxed">
            <p><span class="font-bold text-green-900">Cost</span> adalah biaya jasa service. <span
                    class="font-bold text-green-900">Total</span> mencakup biaya jasa dan biaya tambahan untuk Spare
                Part
                yang diganti jika ada.</p>
        </div>
    </div>
</template>

<style scoped>
@media print {
    @page {
        size: A4;
    }

    body {
        width: 210mm;
        height: 297mm;
        margin: 2 auto;
        padding: 8mm;
    }

    table {
        font-size: 70%;
        width: 100%;
    }

    .border {
        border: 0.5px solid #A9A9A9A9;
        border-radius: 8px;
    }

    #footer {
        font-size: 70%;
    }
}
</style>