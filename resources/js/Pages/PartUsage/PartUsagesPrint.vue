<script setup>
import { computed } from 'vue';

const props = defineProps({
    partUsages: Array,
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
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const totalPrice = computed(() => {
    return props.partUsages.reduce((total, partUsage) => {
        const cost = parseFloat(partUsage.spare_part.price);
        return total + (isNaN(cost) ? 0 : cost);
    }, 0);
});

const totalQuantity = computed(() => {
    return props.partUsages.reduce((total, partUsage) => {
        const quantity = parseFloat(partUsage.quantity);
        return total + (isNaN(quantity) ? 0 : quantity);
    }, 0);
});
</script>

<template>
    <div>
        <div>
            <div v-for="header in $page.props.headers" :key="header.id" class="header-container">
                <h1>Part Usages Report</h1>
                <div class="header-company">
                    <p class="header-text">SIService - {{ header.company }}</p>
                    <p class="header-date">{{ formatDate(startDate) }} - {{ formatDate(endDate) }}</p>
                </div>
            </div>
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
            <tfoot>
                <tr>
                    <td colspan="3">Total Price:</td>
                    <td>{{ formatCurrency(totalPrice) }}</td>
                    <td>{{ totalQuantity }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>