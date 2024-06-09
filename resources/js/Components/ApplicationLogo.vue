<template>
    <div>
      <img :src="faviconSrc" :alt="altText" :class="imgClass">
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const imgWidth = ref('');
  const imgHeight = ref('');
  
  const faviconSrc = '/favicon.ico';
  const altText = 'Favicon';
  
  const imgClass = `${imgWidth.value} ${imgHeight.value}`;
  </script>
  