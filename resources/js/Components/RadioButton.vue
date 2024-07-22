<template>
    <label class="flex items-center px-3 py-1 text-green-900 gap-2">
        <input class="border-green-300 text-green-600 shadow-md focus:ring-green-500" type="radio" :name="name"
            :value="value" @change="handleChange" :checked="checked === value" />
        <slot></slot>
    </label>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
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
    emit('update:checked', props.value);
};
</script>