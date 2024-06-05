<template>
    <div class="flex justify-end">
        <input type="text" v-model="searchQuery" placeholder="Search..." class="border border-gray-300 rounded" />
    </div>
</template>

<script setup>
import { defineEmits, ref, watch } from 'vue';

const emit = defineEmits(['update:searchQuery']);
const searchQuery = ref('');

watch(searchQuery, (newQuery) => {
    emit('update:searchQuery', newQuery);
});
</script>

<style scoped>
/* Add any custom styles for the search input if needed */
</style>
