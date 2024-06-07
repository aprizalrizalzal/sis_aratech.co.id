<template>
    <canvas ref="chartCanvas"></canvas>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Chart from 'chart.js/auto';

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

const chartCanvas = ref(null);
const props = defineProps({
    dataChart: Array,
});

onMounted(() => {
    const ctx = chartCanvas.value;

    const backgroundColors = generateRandomColors(props.dataChart.length).map(color => `${color}33`); // 33 for 20% opacity
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
                borderWidth: 1
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
});
</script>
