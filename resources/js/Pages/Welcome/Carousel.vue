<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue';

const props = defineProps({
    carousels: Array,
});

const currentIndex = ref(0);
const intervalId = ref(null);
const movingForward = ref(true); // Untuk melacak arah pergerakan carousel

const next = () => {
    if (movingForward.value) {
        if (currentIndex.value < props.carousels.length - 1) {
            currentIndex.value += 1;
        } else {
            movingForward.value = false; // Beralih ke mundur
            currentIndex.value -= 1; // Geser satu slide kembali
        }
    } else {
        if (currentIndex.value > 0) {
            currentIndex.value -= 1;
        } else {
            movingForward.value = true; // Beralih ke maju
            currentIndex.value += 1; // Geser satu slide maju
        }
    }
    updateCarouselPosition();
};

const prev = () => {
    if (movingForward.value) {
        if (currentIndex.value > 0) {
            currentIndex.value -= 1;
        } else {
            movingForward.value = false; // Beralih ke mundur
            currentIndex.value += 1; // Geser satu slide maju
        }
    } else {
        if (currentIndex.value < props.carousels.length - 1) {
            currentIndex.value += 1;
        } else {
            movingForward.value = true; // Beralih ke maju
            currentIndex.value -= 1; // Geser satu slide mundur
        }
    }
    updateCarouselPosition();
};

const updateCarouselPosition = async () => {
    await nextTick(); // Tunggu sampai DOM diperbarui
    const carouselWrapper = document.getElementById('carousel-wrapper');
    if (carouselWrapper) {
        const containerWidth = carouselWrapper.parentElement.clientWidth;
        carouselWrapper.style.transform = `translateX(-${currentIndex.value * containerWidth}px)`;
    }
};

const startAutoSlide = () => {
    intervalId.value = setInterval(next, 5000);
};

const stopAutoSlide = () => {
    clearInterval(intervalId.value);
};

onMounted(() => {
    startAutoSlide();
});

onUnmounted(() => {
    stopAutoSlide();
});

// Computed properties for button states
const isNextDisabled = computed(() => (movingForward.value && currentIndex.value === props.carousels.length - 1) || (!movingForward.value && currentIndex.value === 0));
const isPrevDisabled = computed(() => (movingForward.value && currentIndex.value === 0) || (!movingForward.value && currentIndex.value === props.carousels.length - 1));
</script>

<template>
    <div v-if="carousels.length">
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative h-auto overflow-hidden rounded-sm md:h-auto">
                <div id="carousel-wrapper" class="carousel-wrapper flex">
                    <div v-for="(carousel, index) in carousels" :key="carousel.id" class="carousel-slide">
                        <img :src="carousel.image_path" :alt="carousel.alt">
                    </div>
                </div>
            </div>
            <div class="absolute z-30 flex justify-center bottom-5 w-full space-x-3 rtl:space-x-reverse">
                <button v-for="(carousel, index) in carousels" :key="index" type="button"
                    :aria-label="'Slide ' + (index + 1)"
                    :class="['w-3 h-3 rounded-full', { 'bg-white/90': index === currentIndex, 'bg-white/30': index !== currentIndex }]"
                    :aria-current="(index === currentIndex).toString()" :data-carousel-slide-to="index"
                    @click="currentIndex = index; updateCarouselPosition();"></button>
            </div>
            <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                :disabled="isPrevDisabled" data-carousel-prev @click="prev">
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                :disabled="isNextDisabled" data-carousel-next @click="next">
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>
    <div v-else>
        <!-- none -->
    </div>
</template>

<style scoped>
.carousel-wrapper {
    display: flex;
    transition: transform 0.7s ease-in-out;
}

.carousel-slide {
    flex-shrink: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    /* Vertically center */
    justify-content: center;
    /* Horizontally center */
}

.carousel-slide img {
    max-width: 100%;
    /* Ensure image doesn't exceed container width */
    max-height: 100%;
    /* Ensure image doesn't exceed container height */
    object-fit: contain;
    /* Preserve aspect ratio */
}
</style>
