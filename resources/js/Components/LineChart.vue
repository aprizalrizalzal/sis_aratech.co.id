<template>
    <canvas ref="chartCanvas"></canvas>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import Chart from 'chart.js/auto';

const chartCanvas = ref(null);
const props = defineProps({
    dataChart: Array,
});

onMounted(() => {
    const ctx = chartCanvas.value;

    const backgroundColors = generateRandomColors(props.dataChart.length).map(color => `${color}33`);
    const borderColors = generateRandomColors(props.dataChart.length);

    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Users',
                'Device Types',
                'Spare Parts',
                'Carousels',
                'Customers',
                'Devices',
                'Services',
                'Service Details',
                'Part Usages'
            ],
            datasets: [{
                label: 'Count',
                data: props.dataChart,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2,
                pointRadius: 4,
                pointBorderWidth: 2,
                pointHoverBorderWidth: 2,
                pointHoverRadius: 8,
                pointStyle: 'rectRounded'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Watch for changes in dataChart prop
    watch(() => props.dataChart, (newValue, oldValue) => {
        // Update chart data when props.dataChart changes
        myChart.data.datasets[0].data = newValue;
        myChart.update();
    });

    return () => myChart.destroy(); // Cleanup chart on unmount
});

function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function generateRandomColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const color = getRandomColor();
        colors.push(color);
    }
    return colors;
}
</script>
