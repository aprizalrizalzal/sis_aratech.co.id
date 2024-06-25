<script setup>
const props = defineProps({
    partUsages: Array,
    startDate: String,
    endDate: String,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

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
    <h1>Part Usages Report</h1>
    <p>{{ formatDate(startDate)}} - {{ formatDate(endDate)}}</p>
    </div>
    <table>
    <thead>
        <tr>
        <th>No</th>
        <th>Service Detail Code</th>
        <th>Spare Part</th>
        <th>Price</th>
        <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(partUsage, index) in partUsages" :key="partUsage.id">
        <td>{{ index + 1 }}</td>
        <td>{{ partUsage.service_detail.service_detail_code }}</td>
        <td>{{ partUsage.spare_part.name }}</td>
        <td>{{ formatCurrency(partUsage.spare_part.price) }}</td>
        <td>{{ partUsage.quantity }}</td>
        </tr>
    </tbody>
    </table>
</div>
</template>
  