<script setup>
import { defineEmits, ref, watch } from 'vue';
import TextInput from '@/Components/TextInput.vue';

const emit = defineEmits(['update:searchQuery']);
const searchQuery = ref('');

watch(searchQuery, (newQuery) => {
    emit('update:searchQuery', newQuery);
});
</script>

<template>
    <div class="flex justify-end">
        <TextInput type="text" v-model="searchQuery" placeholder="Search..." class="border border-green-300 rounded" />
    </div>
</template>