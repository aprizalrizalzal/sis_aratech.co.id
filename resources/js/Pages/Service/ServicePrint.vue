<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const props = defineProps({
    service: Object,
});

const currentUrl = computed(() => {
    const url = new URL(window.location.href);
    return `${url.host}`;
});

onMounted(() => {
    setTimeout(() => {
        window.print();
    }, 500);
});
</script>

<template id="print-template">

    <Head title="Service Print" />
    <div v-for="header in $page.props.headers" :key="header.id" class="flex items-stretch mt-4 gap-2 text-sm/relaxed">
        <div>
            <ApplicationLogo class="block h-16 w-16" />
        </div>
        <div class="mt-auto">
            <p class="font-bold text-lg">SIService - {{ header.company }}</p>
            <p>{{ header.description }}</p>
        </div>
    </div>
    <br>
    <table class="table-auto w-full">
        <tbody>
            <tr class="font-bold text-green-900">
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                    Service Code
                </td>
                <td class="py-2 px-4 border bg-green-50 border-green-50 text-center">
                    {{ service.service_code }}
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
            <tr class="font-bold text-green-900">
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
            <tr class="font-bold text-green-900">
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
        <p>Kunjungi <a target="_blank" rel="noopener noreferrer" class="text-green-800 font-bold" :href="currentUrl">{{
            currentUrl }}</a>
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
