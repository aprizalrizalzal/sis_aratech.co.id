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
        ? 'block w-full ps-3 pe-4 py-2 border-l-2 border-green-900 text-start text-base font-medium text-green-900 bg-green-100 focus:outline-none focus:text-green-700 focus:bg-green-100 focus:border-green-700 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-2 border-transparent text-start text-base font-medium text-green-700 hover:text-green-700 hover:bg-green-100 hover:border-green-900 focus:outline-none focus:text-green-900 focus:bg-green-100 focus:border-green-900 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
