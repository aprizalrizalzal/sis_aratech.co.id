<script setup>
import { ref } from 'vue';

const imgWidth = ref('');
const imgHeight = ref('');

const headerSrc = '/storage/images/header/company_logo.png';
const altText = 'Favicon';

const imgClass = `${imgWidth.value} ${imgHeight.value}`;
</script>

<template>
  <div>
    <img :src="headerSrc" :alt="altText" :class="imgClass">
  </div>
</template>