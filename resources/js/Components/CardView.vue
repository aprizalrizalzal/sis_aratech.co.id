<template>
    <button
        class="grid grid-cols-1 mb-2 max-w-sm rounded-md text-sm/relaxed overflow-hidden shadow-md bg-white hover:bg-green-50 focus:bg-green-50 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-50 focus:ring-offset-2 hover:ring-green-900/20 dark:hover:ring-zinc-700 ring-1 ring-white/[0.05] transition ease-in-out duration-150">
        <div class="h-full flex items-center justify-center m-1">
            <slot name="img"></slot>
        </div>
        <div class="text-start px-2 pt-4">
            <p class="text-gray-800">{{ name }}</p>
        </div>
        <div class="text-end">
            <span class="inline-block bg-green-50 rounded-md px-2 py-1 text-gray-800 mr-2 mb-2">
                {{ price }}
            </span>
        </div>
    </button>
</template>

<script setup>
const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    price: {
        type: String,
        required: true,
    },
});
</script>