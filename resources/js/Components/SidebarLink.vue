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
        ? 'relative flex flex-row items-center py-7 focus:outline-none bg-green-50 font-bold text-green-900 border-l-4 border-green-900 my-1 pr-6'
        : 'relative flex flex-row items-center py-4 focus:outline-none hover:bg-green-50 hover:font-bold text-green-900 hover:text-green-700 border-l-4 border-transparent hover:border-green-900 pr-6'
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
    <button class="bg-green-900 text-white rounded-full px-3 text-sm ">{{ value }}</button>
    </Link>
</template>
