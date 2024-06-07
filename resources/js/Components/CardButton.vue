<template>
    <button
        class="m-2 p-2 max-w-sm rounded overflow-hidden shadow-lg bg-white hover:bg-green-50 focus:bg-green-50 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <div class="w-full h-48 bg-green-50 flex items-center justify-center rounded">
            <slot name="svg"></slot>
        </div>
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">{{ title }}</div>
            <p class="text-gray-700 text-base">{{ description }}</p>
        </div>
        <div class="px-6 pt-4 pb-2">
            <span v-for="tag in tags" :key="tag"
                class="inline-block bg-green-50 rounded-full px-3 py-1 text-sm font-semibold text-green-700 mr-2 mb-2">
                #{{ tag }}
            </span>
        </div>
    </button>
</template>

<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
    tags: {
        type: Array,
        default: () => [],
    },
});
</script>