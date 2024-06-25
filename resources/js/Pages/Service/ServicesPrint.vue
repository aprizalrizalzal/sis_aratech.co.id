<script setup>
const props = defineProps({
    services: Array,
    startDate: String,
    endDate: String,
});

function formatDate(dateString) {
    const date = new Date(dateString);
    
    const options = {
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
    };

    return date.toLocaleDateString('id-ID', options);
}
</script>

<template>
<div>
    <div>
    <h1>Services Report</h1>
    <p>{{ formatDate(startDate)}} - {{ formatDate(endDate)}}</p>
    </div>
    <table>
    <thead>
        <tr>
        <th>No</th>
        <th>Service  Code</th>
        <th>Customer</th>
        <th>Phone</th>
        <th>Model</th>
        <th>Serial Number</th>
        <th>Date Received</th>
        <th>Items Brought</th>
        <th>Estimated Completion</th>
        <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(service, index) in services" :key="service.id">
        <td>{{ index + 1 }}</td>
        <td>{{ service.service_code }}</td>
        <td>{{ service.customer.user.name }}</td>
        <td>{{ service.customer.phone }}</td>
        <td>{{ service.device.model }}</td>
        <td>{{ service.device.serial_number }}</td>
        <td>{{ service.date_received }}</td>
        <td>{{ service.items_brought }}</td>
        <td>{{ service.estimated_completion }}</td>
        <td>{{ service.status }}</td>
        </tr>
    </tbody>
    </table>
</div>
</template>
  