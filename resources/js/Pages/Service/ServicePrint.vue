<script setup>
const props = defineProps({
    customers: Array,
    devices: Array,
    service: Object,
    customer: Object,
    device: Object,
});
</script>
<template id="print-template">
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Data Layanan</h1>
        <ul>
            <li class="mb-2"><strong class="font-bold">Customer ID:</strong> {{ service.customer_id }}</li>
            <li class="mb-2"><strong class="font-bold">Device ID:</strong> {{ service.device_id }}</li>
            <li class="mb-2"><strong class="font-bold">Date Received:</strong> {{ service.date_received }}</li>
            <li class="mb-2"><strong class="font-bold">Items Brought:</strong> {{ service.items_brought }}</li>
            <li class="mb-2"><strong class="font-bold">Estimated Completion:</strong> {{ service.estimated_completion }}
            </li>
            <li class="mb-2"><strong class="font-bold">Status:</strong> {{ service.status }}</li>
        </ul>
    </div>
</template>
