<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-2 border-green-800 text-start text-base font-medium text-green-800 bg-green-50 focus:outline-none focus:text-green-600 focus:bg-green-50 focus:border-green-600 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-2 border-transparent text-start text-base font-medium text-green-600 hover:text-green-600 hover:bg-green-50 hover:border-green-800 focus:outline-none focus:text-green-800 focus:bg-green-50 focus:border-green-800 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
