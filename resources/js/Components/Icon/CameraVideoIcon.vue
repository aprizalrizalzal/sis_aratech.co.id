<template>
    <svg :xmlns="xmlns" :width="width" :height="height" :fill="fill" :viewBox="viewBox" class="bi bi-camera-video">
        <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2zm11.5 5.175 3.5 1.556V4.269l-3.5 1.556zM2 4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1z"/>
    </svg>
</template>

<script setup>
const props = defineProps({
    width: {
        type: String,
        default: '24',
    },
    height: {
        type: String,
        default: '24',
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