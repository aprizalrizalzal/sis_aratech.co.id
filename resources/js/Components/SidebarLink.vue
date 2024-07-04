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
    value: {
        type: Number,
    },
});

const classes = computed(() =>
    props.active
        ? 'relative flex flex-row items-center py-7 focus:outline-none bg-green-50 text-green-800 border-l-4 border-green-300 my-1 pr-6'
        : 'relative flex flex-row items-center py-4 focus:outline-none hover:bg-green-50 text-green-600 hover:text-green-800 border-l-4 border-transparent hover:border-green-300 pr-6'
);
</script>

<template>
    <Link :href="href" :class="classes" class="flex  justify-between">
    <div>
        <span class="inline-flex items-center ml-2">
            <slot></slot>
        </span>
        <span class="ml-2 text-sm tracking-wide truncate">{{ label }}</span>
    </div>
    <button class="bg-green-800 text-white rounded-full px-2 text-sm ">{{ value }}</button>
    </Link>
</template>
