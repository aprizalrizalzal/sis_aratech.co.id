<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits(['update:searchQuery']);
const props = defineProps({
    placeholder: {
        type: String,
        default: 'Search...',
    },
});
const searchQuery = ref('');

watch(searchQuery, (newQuery) => {
    emit('update:searchQuery', newQuery);
});
</script>

<template>
    <div class="flex w-full justify-end ms-6">
        <input id="search" class="w-full border-green-500 focus:border-green-500 focus:ring-green-500 rounded shadow"
            type="text" v-model="searchQuery" :placeholder="props.placeholder" />
    </div>
</template>