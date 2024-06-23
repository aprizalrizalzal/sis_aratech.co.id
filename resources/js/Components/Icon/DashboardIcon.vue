<template>
    <svg :xmlns="xmlns" :width="width" :height="height" :fill="fill" :viewBox="viewBox" class="bi bi-graph-up">
        <path fill-rule="evenodd"
            d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07" />
    </svg>
</template>

<script setup>
const props = defineProps({
    width: {
        type: String,
        default: '16',
    },
    height: {
        type: String,
        default: '16',
    },
    fill: {
        type: String,
        default: 'currentColor',
    },
    xmlns: {
        type: String,
        default: 'http://www.w3.org/2000/svg',
    },
    viewBox: {
        type: String,
        default: '0 0 16 16',
    },
});
</script>