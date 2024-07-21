<template>
  <div class="date-picker">
    <label :for="id" class="block font-medium text-sm text-green-700 mb-2">{{ label }}</label>
    <input :id="id" v-model="formattedDate"
      class="w-full border-green-600 focus:border-green-600 focus:ring-green-600 rounded-sm shadow-sm"
      :placeholder="placeholder" ref="datepicker" />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';

const props = defineProps({
  id: {
    type: String,
    required: true
  },
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
  const fp = flatpickr(datepicker.value, {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    defaultDate: formattedDate.value,
    onChange: (selectedDates, dateStr) => {
      formattedDate.value = dateStr;
    }
  });

  datepicker.value.addEventListener('focus', () => {
    fp.open();
  });

  datepicker.value.addEventListener('blur', () => {
    setTimeout(() => {
      if (!fp.calendarContainer.contains(document.activeElement)) {
        fp.close();
      }
    }, 100);
  });
});

watch(formattedDate, (newValue) => {
  emit('update:modelValue', newValue);
});
</script>

<style scoped>
.flatpickr-input.flatpickr-mobile {
  display: none;
}
</style>