<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 bg-white border border-green-500 rounded font-semibold text-xs text-green-900 uppercase tracking-widest shadow hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-900 disabled:opacity-25 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
