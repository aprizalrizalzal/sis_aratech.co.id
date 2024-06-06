<template>
    <div>
        <InputLabel class="block font-medium text-sm text-green-700 mb-2" :for="id">{{ label }}</InputLabel>
        <input :id="id" v-model="formattedDate"
            class="w-full border-green-300 focus:border-green-300 focus:ring-green-500 rounded-md shadow-sm"
            ref="datepicker" :placeholder="placeholder" />
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
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

const getCurrentDateTime = () => {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const date = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    return `${year}-${month}-${date} ${hours}:${minutes}`;
};

// Initialize formattedDate with the current datetime or the provided modelValue
const formattedDate = ref(props.modelValue || getCurrentDateTime());

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
