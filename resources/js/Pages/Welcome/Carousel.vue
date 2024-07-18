<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    carousels: Array,
});

const currentIndex = ref(0);
const intervalId = ref(null);

const next = () => {
    currentIndex.value = (currentIndex.value + 1) % props.carousels.length;
    toggleCarouselVisibility();
};

const prev = () => {
    currentIndex.value = (currentIndex.value - 1 + props.carousels.length) % props.carousels.length;
    toggleCarouselVisibility();
};

const toggleCarouselVisibility = () => {
    props.carousels.forEach((carousel, index) => {
        const element = document.getElementById(`carousel-${index}`);
        if (element) {
            if (index === currentIndex.value) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    });
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

</script>

<template>
    <div v-if="carousels.length"
        class="text-center text-sm font-bold text-green-900 my-4 items-center gap-2 rounded-md ring-1 ring-white/[0.05] transition duration-300 hover:text-green-900/70 hover:ring-green-900/20 focus:outline-none focus-visible:ring-green-700">
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative h-56 overflow-hidden rounded-md md:h-96">
                <div v-for="(carousel, index) in carousels" :key="carousel.id" :id="'carousel-' + index"
                    v-show="index === currentIndex" class="duration-700 ease-in-out">
                    <img :src="carousel.image_path" :alt="carousel.alt"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                </div>
            </div>
            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                <button v-for="(carousel, index) in carousels" :key="index" type="button"
                    :aria-label="'Slide ' + (index + 1)" class="w-3 h-3 rounded-full"
                    :aria-current="(index === currentIndex).toString()" :data-carousel-slide-to="index"
                    @click="currentIndex = index; toggleCarouselVisibility();"></button>
            </div>
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev @click="prev">
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next @click="next">
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
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