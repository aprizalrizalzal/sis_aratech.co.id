<template>
    <label class="flex items-center px-3 py-1 text-green-800 gap-2">
        <input class="border-green-200 text-green-600 shadow focus:ring-green-600" type="radio" :name="name"
            :value="value" @change="handleChange" :checked="modelValue === value" />
        <slot></slot>
    </label>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean],
        required: true,
    },
    value: {
        type: [String, Number, Boolean],
        default: null,
    },
    name: {
        type: String,
        required: true,
    },
});

const handleChange = () => {
    emit('update:modelValue', props.value);
};
</script>
