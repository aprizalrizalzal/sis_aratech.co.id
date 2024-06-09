<template>
    <div>
      <!-- Your logo or application header here -->
      <img :src="faviconSrc" :alt="altText" :class="imgClass">
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  // Properti untuk ukuran gambar
  const imgWidth = ref('');
  const imgHeight = ref('');
  
  // Properti untuk favicon
  const faviconSrc = '/favicon.ico';
  const altText = 'Favicon';
  
  // Gabungkan kelas untuk gambar
  const imgClass = `${imgWidth.value} ${imgHeight.value}`;
  </script>
  