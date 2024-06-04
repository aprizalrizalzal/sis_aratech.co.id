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
    label: {
        type: String,
        required: true,
    },
});

const classes = computed(() =>
    props.active
        ? 'relative flex flex-row items-center h-11 focus:outline-none bg-green-100 text-green-800 border-l-4 border-indigo-500 pr-6'
        : 'relative flex flex-row items-center h-11 focus:outline-none hover:bg-green-100 text-green-600 hover:text-green-800 border-l-4 border-transparent hover:border-indigo-500 pr-6'
);
</script>

<template>
    <li>
        <Link :href="href" :class="classes" style="padding-block: 1.80rem;">
        <span class="inline-flex justify-center items-center ml-4">
            <slot></slot>
        </span>
        <span class="ml-2 text-sm tracking-wide truncate">{{ label }}</span>
        </Link>
    </li>
</template>
