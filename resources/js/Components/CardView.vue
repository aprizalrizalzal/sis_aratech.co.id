<template>
    <div
        class="h-full flex flex-col justify-between items-stretch max-w-sm rounded text-sm/relaxed overflow-hidden shadow bg-white hover:bg-green-50 focus:bg-green-50 active:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-50 focus:ring-offset-2 hover:ring-green-700 ring-1 ring-white/[0.05] transition ease-in-out duration-150">
        <div class="h-full flex justify-between items-stretch m-2">
            <slot name="img"></slot>
        </div>
        <div class="text-start px-2 pt-4">
            <p class="text-gray-900 overflow-hidden font-bold">{{ name }}</p>
        </div>
        <div class="text-end">
            <span class="inline-block bg-green-50 rounded mt-2 px-2 py-1 text-green-700 mr-2 mb-2">
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