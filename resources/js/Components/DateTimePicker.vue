<template>
    <div>
        <InputLabel class="block font-medium text-sm text-green-700 mb-2" :for="id">{{ label }}</InputLabel>
        <input :id="id" v-model="formattedDate"
            class="w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm"
            ref="datepicker" :placeholder="placeholder" />
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';

const props = defineProps({
    id: String,
    label: String,
    placeholder: {
        type: String,
        default: "Select Date and Time"
    },
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);
const datepicker = ref(null);

const formattedDate = ref(props.modelValue);

onMounted(() => {
    flatpickr(datepicker.value, {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: formattedDate.value,
        onChange: (selectedDates, dateStr) => {
            formattedDate.value = dateStr;
        }
    });
});

watch(formattedDate, (newValue) => {
    emit('update:modelValue', newValue);
});
</script>
