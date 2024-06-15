<template>
    <div
        class="grid grid-cols-1 m-2 p-2 max-w-sm rounded-md text-sm/relaxed overflow-hidden shadow-lg bg-white hover:bg-green-50 focus:bg-green-50 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-50 focus:ring-offset-2 transition ease-in-out duration-150">
        <div class="h-full p-2 flex items-center justify-center rounded-md">
            <slot name="img"></slot>
        </div>
        <div class="px-2 pt-2">
            <p class="text-gray-800">{{ name }}</p>
        </div>
        <div class="text-end">
            <span class="inline-block bg-green-50 rounded-md px-2 py-1 text-gray-800 mr-2 mb-2">
                {{ price }}
            </span>
        </div>
    </div>
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