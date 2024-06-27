<script setup>
import { computed } from 'vue';

const props = defineProps({
    serviceDetails: Array,
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

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const totalCost = computed(() => {
    return props.serviceDetails.reduce((total, serviceDetail) => {
        const cost = parseFloat(serviceDetail.cost);
        return total + (isNaN(cost) ? 0 : cost);
    }, 0);
});
</script>

<template>
    <div>
        <div>
            <div v-for="header in $page.props.headers" :key="header.id" class="header-container">
                <h1>Service Details Report</h1>
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
                    <th>Technician</th>
                    <th>Service Code</th>
                    <th>Customer</th>
                    <th>Problem Description</th>
                    <th>Repair Description</th>
                    <th>Cost</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(serviceDetail, index) in serviceDetails" :key="serviceDetail.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ serviceDetail.service_detail_code }}</td>
                    <td>{{ serviceDetail.user.name }}</td>
                    <td>{{ serviceDetail.service.service_code }}</td>
                    <td>{{ serviceDetail.service.customer.user.name }}</td>
                    <td>{{ serviceDetail.service.problem_description }}</td>
                    <td>{{ serviceDetail.repair_description }}</td>
                    <td>{{ formatCurrency(serviceDetail.cost) }}</td>
                    <td>{{ serviceDetail.notes }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">Total Cost:</td>
                    <td>{{ formatCurrency(totalCost) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>