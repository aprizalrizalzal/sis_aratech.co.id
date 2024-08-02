<template>
    <button
        class="flex flex-col p-4 max-w-sm rounded text-sm overflow-hidden shadow bg-white hover:bg-green-100 focus:bg-green-100 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-100 focus:ring-offset-2 hover:rounded-none hover:ring-green-300 ring-1 ring-white/[0.05] transition ease-in-out duration-150">
        <div class="flex p-2 gap-4">
            <div class="h-full flex">
                <slot name="svg"></slot>
            </div>
            <div class="font-bold text-xl mb-2">{{ title }}</div>
        </div>
        <p class="text-gray-500 text-left">{{ description }}</p>
        <div class="pt-2">
            <span v-for="tag in tags" :key="tag"
                class="inline-flex bg-green-100 rounded px-2 py-1 text-gray-500 mr-2 mb-2">
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