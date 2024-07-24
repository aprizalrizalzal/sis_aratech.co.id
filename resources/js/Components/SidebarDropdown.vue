<template>
  <div>
    <div @click="toggleDropdown"
      class="flex items-center p-2 text-base font-normal text-green-900 rounded hover:bg-green-50 cursor-pointer"
      :class="{ 'bg-green-200': isActive }">
      <slot name="icon"></slot>
      <span class="ml-2">{{ label }}</span>
      <svg class="ml-auto w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': isOpen }"
        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
          clip-rule="evenodd" />
      </svg>
    </div>
    <ul v-show="isOpen" class="pl-4 space-y-1">
      <slot></slot>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  active: {
    type: Boolean,
    default: false,
  }
});

const isOpen = ref(false);

const isActive = computed(() => props.active);

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};
</script>