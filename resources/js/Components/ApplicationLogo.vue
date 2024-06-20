<script setup>
import { ref } from 'vue';

const imgWidth = ref('');
const imgHeight = ref('');

const faviconSrc = '/storage/images/favicon/company_logo.png';
const altText = 'Favicon';

const imgClass = `${imgWidth.value} ${imgHeight.value}`;
</script>

<template>
  <div>
    <img :src="faviconSrc" :alt="altText" :class="imgClass">
  </div>
</template>