<template>
    <div>
        <label class="block font-medium text-sm text-green-700 mb-2" :for="id">{{ label }}</label>
        <input type="datetime-local" :id="id" v-model="modelValue" class="text-green-700" />
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    id: String,
    label: String,
    placeholder: String,
});
const modelValue = ref('');
const emit = defineEmits(['update:modelValue']);

watch(modelValue, (value) => {
    emit('update:modelValue', value);
});

onMounted(() => {
    console.log('Initialized DateTimePicker component');
});
</script>

<style scoped>
input {
    padding: 0.5rem;
    border: 0.5px solid #2C7373;
    border-radius: 4px;
    width: 100%;
}
</style>