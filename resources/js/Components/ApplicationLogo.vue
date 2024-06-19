<script setup>
import { ref } from 'vue';

const props = defineProps({
  header: Object,
})

const imgWidth = ref('');
const imgHeight = ref('');

const imgClass = `${imgWidth.value} ${imgHeight.value}`;
</script>

<template>
  <div>
    <img :src="header.icon" :alt="header.name" :class="imgClass">
  </div>
</template>