<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const footers = usePage().props.footers;

const contactFooters = computed(() => {
    return footers.filter(footer => footer.type_footer.type === 'Contact');
});

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

<template id="print-service">
    <div class="m-2 px-2">

        <Head :title='"Service " + props.service.service_code' />
        <div v-for="header in $page.props.headers" :key="header.id"
            class="flex items-stretch mb-2 gap-2 text-sm/relaxed">
            <div>
                <ApplicationLogo class="block h-16 w-16" />
            </div>
            <div id="footer" class="mt-auto">
                <p class="font-bold text-xl">SIService - {{ header.company }}</p>
                <p class="text-sm">{{ header.description }}</p>
                <div class="flex text-xs">
                    <div v-for="(footer, index) in contactFooters" :key="footer.id">
                        <p> {{ footer.value }} <span class="font-bold"
                                v-if="index !== contactFooters.length - 1">/</span></p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <table class="table-auto w-full my-2">
            <tbody>
                <tr class="font-bold bg-green-50 ">
                    <td class=" text-green-800">Service Code </td>
                    <td>{{ service.service_code }} </td>
                </tr>
                <tr>
                    <td class=" text-green-800">Name</td>
                    <td>{{ service.customer.user.name }} </td>
                </tr>
                <tr>
                    <td class=" text-green-800">Email / Phone</td>
                    <td>{{ service.customer.user.email }}<span> / </span>{{ service.customer.phone }} </td>
                </tr>
                <tr>
                    <td class=" text-green-800">Address </td>
                    <td>{{ service.customer.address }} </td>
                </tr>
                <tr>
                    <td class=" text-green-800">Device Type / Model</td>
                    <td>{{ service.device.device_type.type_name }}<span> / </span>{{ service.device.model }}</td>
                </tr>
                <tr>
                    <td class=" text-green-800">Serial Number / Warranty Status </td>
                    <td>{{ service.device.serial_number }}<span> / </span>{{ service.status_warranty_service.status }}
                    </td>
                </tr>
                <tr>
                    <td class=" text-green-800">Date Received / Estimated Completion</td>
                    <td>{{ service.date_received }}<span> / </span>{{ service.estimated_completion }} </td>
                </tr>
                <tr>
                    <td class=" text-green-800">Problem Description </td>
                    <td>{{ service.problem_description }} </td>
                </tr>
                <tr>
                    <td class=" text-green-800">Items Brought </td>
                    <td>{{ service.items_brought }} </td>
                </tr>
                <tr class="font-bold bg-green-50">
                    <td class=" text-green-800">Status </td>
                    <td>{{ service.status_service.status }} </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div id="footer" class="flex gap-4 my-2 justify-between text-sm/relaxed text-left">
            <div class="flex flex-col gap-10">
                <p>Admin</p>
                <span>{{ $page.props.auth.user.name }}</span>
            </div>
            <div class="flex flex-col gap-10">
                <p>Customer</p>
                <span>{{ service.customer.user.name }}</span>
            </div>
            <div class="flex flex-col items-left border px-2 mx-1">
                <p class="font-bold">Notes!</p>
                <ul v-for="note in $page.props.notes" :key="note.id">
                    <li>{{ note.description }}</li>
                </ul>
            </div>
        </div>
        <hr>
        <p id="footer" class="mt-2 text-sm/relaxed text-left">
            Cek perkembangan perangkatmu di <a target="_blank" rel="noopener noreferrer"
                class="text-green-800 font-bold" :href="currentUrl">{{ currentUrl }}</a> Jangan lupa cek inbox atau spam
            email Anda ya. Informasi login dan
            password ada di sana!
        </p>
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
