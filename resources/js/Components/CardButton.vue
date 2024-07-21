<template>
    <button
        class="grid grid-cols-1 p-4 max-w-sm rounded-md text-sm/relaxed overflow-hidden shadow-md bg-white hover:bg-green-50 focus:bg-green-50 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-50 focus:ring-offset-2 hover:ring-green-900/20 ring-1 ring-white/[0.05] transition ease-in-out duration-150">
        <div class="h-full flex items-center justify-center">
            <slot name="svg"></slot>
        </div>
        <div class="px-4 py-4">
            <div class="font-bold text-xl mb-2">{{ title }}</div>
            <p class="text-gray-500">{{ description }}</p>
        </div>
        <div class="pt-2 pb-2">
            <span v-for="tag in tags" :key="tag"
                class="inline-block bg-green-50 rounded-md px-2 py-1 text-gray-500 mr-2 mb-2">
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