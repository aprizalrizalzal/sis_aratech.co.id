<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    sparePart: Object,
});

const imageSpareParts = ref(props.sparePart.image_spare_parts || []);
const initialImage = ref(props.sparePart.image_path);
const selectedImage = ref(initialImage.value);

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
};

const formatDescription = (description) => {
    return description.replace(/\n/g, '<br>');
};

const selectImage = (imagePath) => {
    selectedImage.value = (selectedImage.value === imagePath) ? initialImage.value : imagePath;
};

watch(() => props.sparePart.image_path, (newValue) => {
    initialImage.value = newValue;
    selectedImage.value = newValue;
});
</script>

<template>
    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4 mt-4">
        <div class="h-full">
            <img :src="selectedImage" :alt="sparePart.name" class="rounded-sm shadow-sm">
            <div v-if="imageSpareParts.length" class="mt-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-4">
                    <div v-for="(imageSparePart, index) in imageSpareParts" :key="index" class="relative">
                        <img :src="imageSparePart.image_path" alt="Image Spare Part"
                            class="w-full h-auto rounded-sm cursor-pointer"
                            @click="selectImage(imageSparePart.image_path)" />
                    </div>
                </div>
            </div>
        </div>
        <div class="text-start">
            <h1 class="text-gray-900 font-bold sm:text-lg text-md">{{ sparePart.name }}</h1>
            <p class="text-sm/relaxed font-bold py-1 rounded-sm text-gray-700">
                {{ sparePart.category_spare_part.name }}
            </p>
            <p class="text-gray-500 text-sm/relaxed font-bold mb-2">
                <span>Pieces </span>{{ sparePart.pieces }}
            </p>
            <hr>
            <p class="text-gray-700 text-sm/relaxed overflow-hidden" v-html="formatDescription(sparePart.description)">
            </p>
            <hr>
            <p class="inline-block py-2 rounded-sm font-bold text-gray-900 mt-2">
                {{ formatCurrency(sparePart.price) }}
            </p>
        </div>
    </div>
</template>

<style scoped>
.relative {
    position: relative;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
